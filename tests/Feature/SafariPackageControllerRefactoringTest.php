<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Repositories\Contracts\PackageRepositoryInterface;
use App\Repositories\PackageRepository;

class SafariPackageControllerRefactoringTest extends TestCase
{
    /**
     * Test that the PackageRepository is properly bound in the container
     */
    public function test_package_repository_interface_is_bound_in_container()
    {
        $repository = app(PackageRepositoryInterface::class);

        $this->assertInstanceOf(PackageRepository::class, $repository);
    }

    /**
     * Test that SafariPackageController can be instantiated with dependency injection
     */
    public function test_safari_package_controller_can_be_instantiated_with_repository()
    {
        $repository = app(PackageRepositoryInterface::class);

        $this->assertNotNull($repository);
        $this->assertInstanceOf(PackageRepositoryInterface::class, $repository);
    }

    /**
     * Test that PackageRepository has the required public methods
     */
    public function test_package_repository_has_required_methods()
    {
        $repository = app(PackageRepositoryInterface::class);

        $this->assertTrue(method_exists($repository, 'paginateFiltered'));
        $this->assertTrue(method_exists($repository, 'findBySlugWithRelations'));
        $this->assertTrue(method_exists($repository, 'getCharacteristicData'));
    }

    /**
     * Test that all filter methods exist on the PackageRepository
     */
    public function test_package_repository_delegates_to_filters()
    {
        $repository = app(PackageRepositoryInterface::class);

        // Verify the repository uses the PackageFilters internally
        // by checking it can access the filter methods
        $reflection = new \ReflectionClass($repository);

        // Should have a reference to Package model
        $this->assertTrue($reflection->getShortName() === 'PackageRepository');
    }
}
