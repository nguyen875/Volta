<?php
// app/controllers/ProfileController.php
// Customer profile + address management

require_once __DIR__ . '/../helpers/Auth.php';
require_once __DIR__ . '/../helpers/ApiResponse.php';
require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../services/AddressService.php';

class ProfileController
{
    private UserService $userService;
    private AddressService $addressService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->addressService = new AddressService();
    }

    /**
     * GET /api/profile
     */
    public function index(): void
    {
        Auth::requireLogin();

        $user = $this->userService->getById(Auth::userId());
        if (!$user) {
            ApiResponse::error('User not found.', 404);
        }

        $addresses = $this->addressService->getByUser(Auth::userId());

        ApiResponse::success([
            'user'      => ApiResponse::dto($user),
            'addresses' => ApiResponse::dtoList($addresses),
        ]);
    }

    /**
     * PUT /api/profile
     * Body: { full_name?, phone?, password? }
     */
    public function update(): void
    {
        Auth::requireLogin();

        $data = ApiResponse::body();
        $this->userService->update(Auth::userId(), $data);

        $user = $this->userService->getById(Auth::userId());

        ApiResponse::success(
            $user ? ApiResponse::dto($user) : null,
            'Profile updated successfully.'
        );
    }

    // ══════════════════════════════════════════════════════════
    //  ADDRESSES
    // ══════════════════════════════════════════════════════════

    /**
     * GET /api/profile/addresses
     */
    public function addresses(): void
    {
        Auth::requireLogin();

        $addresses = $this->addressService->getByUser(Auth::userId());
        ApiResponse::success(ApiResponse::dtoList($addresses));
    }

    /**
     * POST /api/profile/addresses
     * Body: { label?, street, city, country?, is_default? }
     */
    public function addAddress(): void
    {
        Auth::requireLogin();

        $data = ApiResponse::body();

        try {
            $id = $this->addressService->create(Auth::userId(), $data);
            $address = $this->addressService->getById($id);

            ApiResponse::success(
                $address ? ApiResponse::dto($address) : ['id' => $id],
                'Address added successfully.',
                201
            );
        } catch (\InvalidArgumentException $e) {
            ApiResponse::error($e->getMessage(), 422);
        }
    }

    /**
     * PUT /api/profile/addresses/{id}
     * Body: { label?, street?, city?, country?, is_default? }
     */
    public function updateAddress(int $id): void
    {
        Auth::requireLogin();

        // Verify address belongs to the user
        $address = $this->addressService->getById($id);
        if (!$address || $address->userId !== Auth::userId()) {
            ApiResponse::error('Address not found.', 404);
        }

        $data = ApiResponse::body();

        // Handle setting default
        if (!empty($data['is_default'])) {
            $this->addressService->setDefault(Auth::userId(), $id);
        }

        $this->addressService->update($id, $data);

        $updated = $this->addressService->getById($id);
        ApiResponse::success(
            $updated ? ApiResponse::dto($updated) : null,
            'Address updated successfully.'
        );
    }

    /**
     * DELETE /api/profile/addresses/{id}
     */
    public function deleteAddress(int $id): void
    {
        Auth::requireLogin();

        // Verify address belongs to the user
        $address = $this->addressService->getById($id);
        if (!$address || $address->userId !== Auth::userId()) {
            ApiResponse::error('Address not found.', 404);
        }

        $this->addressService->delete($id);
        ApiResponse::success(null, 'Address deleted successfully.');
    }
}
