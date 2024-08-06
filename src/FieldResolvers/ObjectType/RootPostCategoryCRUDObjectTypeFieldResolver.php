<?php

declare(strict_types=1);

namespace PoPCMSSchema\PostCategoryMutations\FieldResolvers\ObjectType;

use PoPCMSSchema\CategoryMutations\Module;
use PoPCMSSchema\CategoryMutations\ModuleConfiguration;
use PoPCMSSchema\CategoryMutations\TypeResolvers\InputObjectType\RootCreateCategoryTermInputObjectTypeResolver;
use PoPCMSSchema\CategoryMutations\TypeResolvers\InputObjectType\RootDeleteCategoryTermInputObjectTypeResolver;
use PoPCMSSchema\CategoryMutations\TypeResolvers\InputObjectType\RootUpdateCategoryTermInputObjectTypeResolver;
use PoPCMSSchema\PostCategories\TypeResolvers\ObjectType\PostCategoryObjectTypeResolver;
use PoPCMSSchema\PostCategoryMutations\MutationResolvers\CreatePostCategoryTermBulkOperationMutationResolver;
use PoPCMSSchema\PostCategoryMutations\MutationResolvers\CreatePostCategoryTermMutationResolver;
use PoPCMSSchema\PostCategoryMutations\MutationResolvers\DeletePostCategoryTermBulkOperationMutationResolver;
use PoPCMSSchema\PostCategoryMutations\MutationResolvers\DeletePostCategoryTermMutationResolver;
use PoPCMSSchema\PostCategoryMutations\MutationResolvers\PayloadableCreatePostCategoryTermBulkOperationMutationResolver;
use PoPCMSSchema\PostCategoryMutations\MutationResolvers\PayloadableCreatePostCategoryTermMutationResolver;
use PoPCMSSchema\PostCategoryMutations\MutationResolvers\PayloadableDeletePostCategoryTermBulkOperationMutationResolver;
use PoPCMSSchema\PostCategoryMutations\MutationResolvers\PayloadableDeletePostCategoryTermMutationResolver;
use PoPCMSSchema\PostCategoryMutations\MutationResolvers\PayloadableUpdatePostCategoryTermBulkOperationMutationResolver;
use PoPCMSSchema\PostCategoryMutations\MutationResolvers\PayloadableUpdatePostCategoryTermMutationResolver;
use PoPCMSSchema\PostCategoryMutations\MutationResolvers\UpdatePostCategoryTermBulkOperationMutationResolver;
use PoPCMSSchema\PostCategoryMutations\MutationResolvers\UpdatePostCategoryTermMutationResolver;
use PoPCMSSchema\PostCategoryMutations\TypeResolvers\ObjectType\RootCreatePostCategoryTermMutationPayloadObjectTypeResolver;
use PoPCMSSchema\PostCategoryMutations\TypeResolvers\ObjectType\RootDeletePostCategoryTermMutationPayloadObjectTypeResolver;
use PoPCMSSchema\PostCategoryMutations\TypeResolvers\ObjectType\RootUpdatePostCategoryTermMutationPayloadObjectTypeResolver;
use PoPCMSSchema\SchemaCommons\FieldResolvers\ObjectType\BulkOperationDecoratorObjectTypeFieldResolverTrait;
use PoPCMSSchema\SchemaCommons\FieldResolvers\ObjectType\MutationPayloadObjectsObjectTypeFieldResolverTrait;
use PoPCMSSchema\UserState\Checkpoints\UserLoggedInCheckpoint;
use PoP\ComponentModel\Checkpoints\CheckpointInterface;
use PoP\ComponentModel\Feedback\ObjectTypeFieldResolutionFeedbackStore;
use PoP\ComponentModel\FieldResolvers\ObjectType\AbstractObjectTypeFieldResolver;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoP\ComponentModel\QueryResolution\FieldDataAccessorInterface;
use PoP\ComponentModel\Schema\SchemaTypeModifiers;
use PoP\ComponentModel\TypeResolvers\ConcreteTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\InputTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ObjectType\ObjectTypeResolverInterface;
use PoP\ComponentModel\TypeResolvers\ScalarType\BooleanScalarTypeResolver;
use PoP\Engine\Module as EngineModule;
use PoP\Engine\ModuleConfiguration as EngineModuleConfiguration;
use PoP\Engine\TypeResolvers\ObjectType\RootObjectTypeResolver;
use PoP\Root\App;

class RootPostCategoryCRUDObjectTypeFieldResolver extends AbstractObjectTypeFieldResolver
{
    use MutationPayloadObjectsObjectTypeFieldResolverTrait;
    use BulkOperationDecoratorObjectTypeFieldResolverTrait;

    private ?PostCategoryObjectTypeResolver $postCategoryObjectTypeResolver = null;
    private ?RootDeletePostCategoryTermMutationPayloadObjectTypeResolver $rootDeletePostCategoryTermMutationPayloadObjectTypeResolver = null;
    private ?RootUpdatePostCategoryTermMutationPayloadObjectTypeResolver $rootUpdatePostCategoryTermMutationPayloadObjectTypeResolver = null;
    private ?RootCreatePostCategoryTermMutationPayloadObjectTypeResolver $rootCreatePostCategoryTermMutationPayloadObjectTypeResolver = null;
    private ?CreatePostCategoryTermMutationResolver $createPostCategoryTermMutationResolver = null;
    private ?CreatePostCategoryTermBulkOperationMutationResolver $createPostCategoryTermBulkOperationMutationResolver = null;
    private ?DeletePostCategoryTermMutationResolver $deletePostCategoryTermMutationResolver = null;
    private ?DeletePostCategoryTermBulkOperationMutationResolver $deletePostCategoryTermBulkOperationMutationResolver = null;
    private ?UpdatePostCategoryTermMutationResolver $updatePostCategoryTermMutationResolver = null;
    private ?UpdatePostCategoryTermBulkOperationMutationResolver $updatePostCategoryTermBulkOperationMutationResolver = null;
    private ?PayloadableDeletePostCategoryTermMutationResolver $payloadableDeletePostCategoryTermMutationResolver = null;
    private ?PayloadableDeletePostCategoryTermBulkOperationMutationResolver $payloadableDeletePostCategoryTermBulkOperationMutationResolver = null;
    private ?PayloadableUpdatePostCategoryTermMutationResolver $payloadableUpdatePostCategoryTermMutationResolver = null;
    private ?PayloadableUpdatePostCategoryTermBulkOperationMutationResolver $payloadableUpdatePostCategoryTermBulkOperationMutationResolver = null;
    private ?PayloadableCreatePostCategoryTermMutationResolver $payloadableCreatePostCategoryTermMutationResolver = null;
    private ?PayloadableCreatePostCategoryTermBulkOperationMutationResolver $payloadableCreatePostCategoryTermBulkOperationMutationResolver = null;
    private ?RootDeleteCategoryTermInputObjectTypeResolver $rootDeleteCategoryTermInputObjectTypeResolver = null;
    private ?RootUpdateCategoryTermInputObjectTypeResolver $rootUpdateCategoryTermInputObjectTypeResolver = null;
    private ?RootCreateCategoryTermInputObjectTypeResolver $rootCreateCategoryTermInputObjectTypeResolver = null;
    private ?UserLoggedInCheckpoint $userLoggedInCheckpoint = null;
    private ?BooleanScalarTypeResolver $booleanScalarTypeResolver = null;

    final public function setPostCategoryObjectTypeResolver(PostCategoryObjectTypeResolver $postCategoryObjectTypeResolver): void
    {
        $this->postCategoryObjectTypeResolver = $postCategoryObjectTypeResolver;
    }
    final protected function getPostCategoryObjectTypeResolver(): PostCategoryObjectTypeResolver
    {
        if ($this->postCategoryObjectTypeResolver === null) {
            /** @var PostCategoryObjectTypeResolver */
            $postCategoryObjectTypeResolver = $this->instanceManager->getInstance(PostCategoryObjectTypeResolver::class);
            $this->postCategoryObjectTypeResolver = $postCategoryObjectTypeResolver;
        }
        return $this->postCategoryObjectTypeResolver;
    }
    final public function setRootDeletePostCategoryTermMutationPayloadObjectTypeResolver(RootDeletePostCategoryTermMutationPayloadObjectTypeResolver $rootDeletePostCategoryTermMutationPayloadObjectTypeResolver): void
    {
        $this->rootDeletePostCategoryTermMutationPayloadObjectTypeResolver = $rootDeletePostCategoryTermMutationPayloadObjectTypeResolver;
    }
    final protected function getRootDeletePostCategoryTermMutationPayloadObjectTypeResolver(): RootDeletePostCategoryTermMutationPayloadObjectTypeResolver
    {
        if ($this->rootDeletePostCategoryTermMutationPayloadObjectTypeResolver === null) {
            /** @var RootDeletePostCategoryTermMutationPayloadObjectTypeResolver */
            $rootDeletePostCategoryTermMutationPayloadObjectTypeResolver = $this->instanceManager->getInstance(RootDeletePostCategoryTermMutationPayloadObjectTypeResolver::class);
            $this->rootDeletePostCategoryTermMutationPayloadObjectTypeResolver = $rootDeletePostCategoryTermMutationPayloadObjectTypeResolver;
        }
        return $this->rootDeletePostCategoryTermMutationPayloadObjectTypeResolver;
    }
    final public function setRootUpdatePostCategoryTermMutationPayloadObjectTypeResolver(RootUpdatePostCategoryTermMutationPayloadObjectTypeResolver $rootUpdatePostCategoryTermMutationPayloadObjectTypeResolver): void
    {
        $this->rootUpdatePostCategoryTermMutationPayloadObjectTypeResolver = $rootUpdatePostCategoryTermMutationPayloadObjectTypeResolver;
    }
    final protected function getRootUpdatePostCategoryTermMutationPayloadObjectTypeResolver(): RootUpdatePostCategoryTermMutationPayloadObjectTypeResolver
    {
        if ($this->rootUpdatePostCategoryTermMutationPayloadObjectTypeResolver === null) {
            /** @var RootUpdatePostCategoryTermMutationPayloadObjectTypeResolver */
            $rootUpdatePostCategoryTermMutationPayloadObjectTypeResolver = $this->instanceManager->getInstance(RootUpdatePostCategoryTermMutationPayloadObjectTypeResolver::class);
            $this->rootUpdatePostCategoryTermMutationPayloadObjectTypeResolver = $rootUpdatePostCategoryTermMutationPayloadObjectTypeResolver;
        }
        return $this->rootUpdatePostCategoryTermMutationPayloadObjectTypeResolver;
    }
    final public function setRootCreatePostCategoryTermMutationPayloadObjectTypeResolver(RootCreatePostCategoryTermMutationPayloadObjectTypeResolver $rootCreatePostCategoryTermMutationPayloadObjectTypeResolver): void
    {
        $this->rootCreatePostCategoryTermMutationPayloadObjectTypeResolver = $rootCreatePostCategoryTermMutationPayloadObjectTypeResolver;
    }
    final protected function getRootCreatePostCategoryTermMutationPayloadObjectTypeResolver(): RootCreatePostCategoryTermMutationPayloadObjectTypeResolver
    {
        if ($this->rootCreatePostCategoryTermMutationPayloadObjectTypeResolver === null) {
            /** @var RootCreatePostCategoryTermMutationPayloadObjectTypeResolver */
            $rootCreatePostCategoryTermMutationPayloadObjectTypeResolver = $this->instanceManager->getInstance(RootCreatePostCategoryTermMutationPayloadObjectTypeResolver::class);
            $this->rootCreatePostCategoryTermMutationPayloadObjectTypeResolver = $rootCreatePostCategoryTermMutationPayloadObjectTypeResolver;
        }
        return $this->rootCreatePostCategoryTermMutationPayloadObjectTypeResolver;
    }
    final public function setCreatePostCategoryTermMutationResolver(CreatePostCategoryTermMutationResolver $createPostCategoryTermMutationResolver): void
    {
        $this->createPostCategoryTermMutationResolver = $createPostCategoryTermMutationResolver;
    }
    final protected function getCreatePostCategoryTermMutationResolver(): CreatePostCategoryTermMutationResolver
    {
        if ($this->createPostCategoryTermMutationResolver === null) {
            /** @var CreatePostCategoryTermMutationResolver */
            $createPostCategoryTermMutationResolver = $this->instanceManager->getInstance(CreatePostCategoryTermMutationResolver::class);
            $this->createPostCategoryTermMutationResolver = $createPostCategoryTermMutationResolver;
        }
        return $this->createPostCategoryTermMutationResolver;
    }
    final public function setCreatePostCategoryTermBulkOperationMutationResolver(CreatePostCategoryTermBulkOperationMutationResolver $createPostCategoryTermBulkOperationMutationResolver): void
    {
        $this->createPostCategoryTermBulkOperationMutationResolver = $createPostCategoryTermBulkOperationMutationResolver;
    }
    final protected function getCreatePostCategoryTermBulkOperationMutationResolver(): CreatePostCategoryTermBulkOperationMutationResolver
    {
        if ($this->createPostCategoryTermBulkOperationMutationResolver === null) {
            /** @var CreatePostCategoryTermBulkOperationMutationResolver */
            $createPostCategoryTermBulkOperationMutationResolver = $this->instanceManager->getInstance(CreatePostCategoryTermBulkOperationMutationResolver::class);
            $this->createPostCategoryTermBulkOperationMutationResolver = $createPostCategoryTermBulkOperationMutationResolver;
        }
        return $this->createPostCategoryTermBulkOperationMutationResolver;
    }
    final public function setDeletePostCategoryTermMutationResolver(DeletePostCategoryTermMutationResolver $deletePostCategoryTermMutationResolver): void
    {
        $this->deletePostCategoryTermMutationResolver = $deletePostCategoryTermMutationResolver;
    }
    final protected function getDeletePostCategoryTermMutationResolver(): DeletePostCategoryTermMutationResolver
    {
        if ($this->deletePostCategoryTermMutationResolver === null) {
            /** @var DeletePostCategoryTermMutationResolver */
            $deletePostCategoryTermMutationResolver = $this->instanceManager->getInstance(DeletePostCategoryTermMutationResolver::class);
            $this->deletePostCategoryTermMutationResolver = $deletePostCategoryTermMutationResolver;
        }
        return $this->deletePostCategoryTermMutationResolver;
    }
    final public function setDeletePostCategoryTermBulkOperationMutationResolver(DeletePostCategoryTermBulkOperationMutationResolver $deletePostCategoryTermBulkOperationMutationResolver): void
    {
        $this->deletePostCategoryTermBulkOperationMutationResolver = $deletePostCategoryTermBulkOperationMutationResolver;
    }
    final protected function getDeletePostCategoryTermBulkOperationMutationResolver(): DeletePostCategoryTermBulkOperationMutationResolver
    {
        if ($this->deletePostCategoryTermBulkOperationMutationResolver === null) {
            /** @var DeletePostCategoryTermBulkOperationMutationResolver */
            $deletePostCategoryTermBulkOperationMutationResolver = $this->instanceManager->getInstance(DeletePostCategoryTermBulkOperationMutationResolver::class);
            $this->deletePostCategoryTermBulkOperationMutationResolver = $deletePostCategoryTermBulkOperationMutationResolver;
        }
        return $this->deletePostCategoryTermBulkOperationMutationResolver;
    }
    final public function setUpdatePostCategoryTermMutationResolver(UpdatePostCategoryTermMutationResolver $updatePostCategoryTermMutationResolver): void
    {
        $this->updatePostCategoryTermMutationResolver = $updatePostCategoryTermMutationResolver;
    }
    final protected function getUpdatePostCategoryTermMutationResolver(): UpdatePostCategoryTermMutationResolver
    {
        if ($this->updatePostCategoryTermMutationResolver === null) {
            /** @var UpdatePostCategoryTermMutationResolver */
            $updatePostCategoryTermMutationResolver = $this->instanceManager->getInstance(UpdatePostCategoryTermMutationResolver::class);
            $this->updatePostCategoryTermMutationResolver = $updatePostCategoryTermMutationResolver;
        }
        return $this->updatePostCategoryTermMutationResolver;
    }
    final public function setUpdatePostCategoryTermBulkOperationMutationResolver(UpdatePostCategoryTermBulkOperationMutationResolver $updatePostCategoryTermBulkOperationMutationResolver): void
    {
        $this->updatePostCategoryTermBulkOperationMutationResolver = $updatePostCategoryTermBulkOperationMutationResolver;
    }
    final protected function getUpdatePostCategoryTermBulkOperationMutationResolver(): UpdatePostCategoryTermBulkOperationMutationResolver
    {
        if ($this->updatePostCategoryTermBulkOperationMutationResolver === null) {
            /** @var UpdatePostCategoryTermBulkOperationMutationResolver */
            $updatePostCategoryTermBulkOperationMutationResolver = $this->instanceManager->getInstance(UpdatePostCategoryTermBulkOperationMutationResolver::class);
            $this->updatePostCategoryTermBulkOperationMutationResolver = $updatePostCategoryTermBulkOperationMutationResolver;
        }
        return $this->updatePostCategoryTermBulkOperationMutationResolver;
    }
    final public function setPayloadableDeletePostCategoryTermMutationResolver(PayloadableDeletePostCategoryTermMutationResolver $payloadableDeletePostCategoryTermMutationResolver): void
    {
        $this->payloadableDeletePostCategoryTermMutationResolver = $payloadableDeletePostCategoryTermMutationResolver;
    }
    final protected function getPayloadableDeletePostCategoryTermMutationResolver(): PayloadableDeletePostCategoryTermMutationResolver
    {
        if ($this->payloadableDeletePostCategoryTermMutationResolver === null) {
            /** @var PayloadableDeletePostCategoryTermMutationResolver */
            $payloadableDeletePostCategoryTermMutationResolver = $this->instanceManager->getInstance(PayloadableDeletePostCategoryTermMutationResolver::class);
            $this->payloadableDeletePostCategoryTermMutationResolver = $payloadableDeletePostCategoryTermMutationResolver;
        }
        return $this->payloadableDeletePostCategoryTermMutationResolver;
    }
    final public function setPayloadableDeletePostCategoryTermBulkOperationMutationResolver(PayloadableDeletePostCategoryTermBulkOperationMutationResolver $payloadableDeletePostCategoryTermBulkOperationMutationResolver): void
    {
        $this->payloadableDeletePostCategoryTermBulkOperationMutationResolver = $payloadableDeletePostCategoryTermBulkOperationMutationResolver;
    }
    final protected function getPayloadableDeletePostCategoryTermBulkOperationMutationResolver(): PayloadableDeletePostCategoryTermBulkOperationMutationResolver
    {
        if ($this->payloadableDeletePostCategoryTermBulkOperationMutationResolver === null) {
            /** @var PayloadableDeletePostCategoryTermBulkOperationMutationResolver */
            $payloadableDeletePostCategoryTermBulkOperationMutationResolver = $this->instanceManager->getInstance(PayloadableDeletePostCategoryTermBulkOperationMutationResolver::class);
            $this->payloadableDeletePostCategoryTermBulkOperationMutationResolver = $payloadableDeletePostCategoryTermBulkOperationMutationResolver;
        }
        return $this->payloadableDeletePostCategoryTermBulkOperationMutationResolver;
    }
    final public function setPayloadableUpdatePostCategoryTermMutationResolver(PayloadableUpdatePostCategoryTermMutationResolver $payloadableUpdatePostCategoryTermMutationResolver): void
    {
        $this->payloadableUpdatePostCategoryTermMutationResolver = $payloadableUpdatePostCategoryTermMutationResolver;
    }
    final protected function getPayloadableUpdatePostCategoryTermMutationResolver(): PayloadableUpdatePostCategoryTermMutationResolver
    {
        if ($this->payloadableUpdatePostCategoryTermMutationResolver === null) {
            /** @var PayloadableUpdatePostCategoryTermMutationResolver */
            $payloadableUpdatePostCategoryTermMutationResolver = $this->instanceManager->getInstance(PayloadableUpdatePostCategoryTermMutationResolver::class);
            $this->payloadableUpdatePostCategoryTermMutationResolver = $payloadableUpdatePostCategoryTermMutationResolver;
        }
        return $this->payloadableUpdatePostCategoryTermMutationResolver;
    }
    final public function setPayloadableUpdatePostCategoryTermBulkOperationMutationResolver(PayloadableUpdatePostCategoryTermBulkOperationMutationResolver $payloadableUpdatePostCategoryTermBulkOperationMutationResolver): void
    {
        $this->payloadableUpdatePostCategoryTermBulkOperationMutationResolver = $payloadableUpdatePostCategoryTermBulkOperationMutationResolver;
    }
    final protected function getPayloadableUpdatePostCategoryTermBulkOperationMutationResolver(): PayloadableUpdatePostCategoryTermBulkOperationMutationResolver
    {
        if ($this->payloadableUpdatePostCategoryTermBulkOperationMutationResolver === null) {
            /** @var PayloadableUpdatePostCategoryTermBulkOperationMutationResolver */
            $payloadableUpdatePostCategoryTermBulkOperationMutationResolver = $this->instanceManager->getInstance(PayloadableUpdatePostCategoryTermBulkOperationMutationResolver::class);
            $this->payloadableUpdatePostCategoryTermBulkOperationMutationResolver = $payloadableUpdatePostCategoryTermBulkOperationMutationResolver;
        }
        return $this->payloadableUpdatePostCategoryTermBulkOperationMutationResolver;
    }
    final public function setPayloadableCreatePostCategoryTermMutationResolver(PayloadableCreatePostCategoryTermMutationResolver $payloadableCreatePostCategoryTermMutationResolver): void
    {
        $this->payloadableCreatePostCategoryTermMutationResolver = $payloadableCreatePostCategoryTermMutationResolver;
    }
    final protected function getPayloadableCreatePostCategoryTermMutationResolver(): PayloadableCreatePostCategoryTermMutationResolver
    {
        if ($this->payloadableCreatePostCategoryTermMutationResolver === null) {
            /** @var PayloadableCreatePostCategoryTermMutationResolver */
            $payloadableCreatePostCategoryTermMutationResolver = $this->instanceManager->getInstance(PayloadableCreatePostCategoryTermMutationResolver::class);
            $this->payloadableCreatePostCategoryTermMutationResolver = $payloadableCreatePostCategoryTermMutationResolver;
        }
        return $this->payloadableCreatePostCategoryTermMutationResolver;
    }
    final public function setPayloadableCreatePostCategoryTermBulkOperationMutationResolver(PayloadableCreatePostCategoryTermBulkOperationMutationResolver $payloadableCreatePostCategoryTermBulkOperationMutationResolver): void
    {
        $this->payloadableCreatePostCategoryTermBulkOperationMutationResolver = $payloadableCreatePostCategoryTermBulkOperationMutationResolver;
    }
    final protected function getPayloadableCreatePostCategoryTermBulkOperationMutationResolver(): PayloadableCreatePostCategoryTermBulkOperationMutationResolver
    {
        if ($this->payloadableCreatePostCategoryTermBulkOperationMutationResolver === null) {
            /** @var PayloadableCreatePostCategoryTermBulkOperationMutationResolver */
            $payloadableCreatePostCategoryTermBulkOperationMutationResolver = $this->instanceManager->getInstance(PayloadableCreatePostCategoryTermBulkOperationMutationResolver::class);
            $this->payloadableCreatePostCategoryTermBulkOperationMutationResolver = $payloadableCreatePostCategoryTermBulkOperationMutationResolver;
        }
        return $this->payloadableCreatePostCategoryTermBulkOperationMutationResolver;
    }
    final public function setRootDeleteCategoryTermInputObjectTypeResolver(RootDeleteCategoryTermInputObjectTypeResolver $rootDeleteCategoryTermInputObjectTypeResolver): void
    {
        $this->rootDeleteCategoryTermInputObjectTypeResolver = $rootDeleteCategoryTermInputObjectTypeResolver;
    }
    final protected function getRootDeleteCategoryTermInputObjectTypeResolver(): RootDeleteCategoryTermInputObjectTypeResolver
    {
        if ($this->rootDeleteCategoryTermInputObjectTypeResolver === null) {
            /** @var RootDeleteCategoryTermInputObjectTypeResolver */
            $rootDeleteCategoryTermInputObjectTypeResolver = $this->instanceManager->getInstance(RootDeleteCategoryTermInputObjectTypeResolver::class);
            $this->rootDeleteCategoryTermInputObjectTypeResolver = $rootDeleteCategoryTermInputObjectTypeResolver;
        }
        return $this->rootDeleteCategoryTermInputObjectTypeResolver;
    }
    final public function setRootUpdateCategoryTermInputObjectTypeResolver(RootUpdateCategoryTermInputObjectTypeResolver $rootUpdateCategoryTermInputObjectTypeResolver): void
    {
        $this->rootUpdateCategoryTermInputObjectTypeResolver = $rootUpdateCategoryTermInputObjectTypeResolver;
    }
    final protected function getRootUpdateCategoryTermInputObjectTypeResolver(): RootUpdateCategoryTermInputObjectTypeResolver
    {
        if ($this->rootUpdateCategoryTermInputObjectTypeResolver === null) {
            /** @var RootUpdateCategoryTermInputObjectTypeResolver */
            $rootUpdateCategoryTermInputObjectTypeResolver = $this->instanceManager->getInstance(RootUpdateCategoryTermInputObjectTypeResolver::class);
            $this->rootUpdateCategoryTermInputObjectTypeResolver = $rootUpdateCategoryTermInputObjectTypeResolver;
        }
        return $this->rootUpdateCategoryTermInputObjectTypeResolver;
    }
    final public function setRootCreateCategoryTermInputObjectTypeResolver(RootCreateCategoryTermInputObjectTypeResolver $rootCreateCategoryTermInputObjectTypeResolver): void
    {
        $this->rootCreateCategoryTermInputObjectTypeResolver = $rootCreateCategoryTermInputObjectTypeResolver;
    }
    final protected function getRootCreateCategoryTermInputObjectTypeResolver(): RootCreateCategoryTermInputObjectTypeResolver
    {
        if ($this->rootCreateCategoryTermInputObjectTypeResolver === null) {
            /** @var RootCreateCategoryTermInputObjectTypeResolver */
            $rootCreateCategoryTermInputObjectTypeResolver = $this->instanceManager->getInstance(RootCreateCategoryTermInputObjectTypeResolver::class);
            $this->rootCreateCategoryTermInputObjectTypeResolver = $rootCreateCategoryTermInputObjectTypeResolver;
        }
        return $this->rootCreateCategoryTermInputObjectTypeResolver;
    }
    final public function setUserLoggedInCheckpoint(UserLoggedInCheckpoint $userLoggedInCheckpoint): void
    {
        $this->userLoggedInCheckpoint = $userLoggedInCheckpoint;
    }
    final protected function getUserLoggedInCheckpoint(): UserLoggedInCheckpoint
    {
        if ($this->userLoggedInCheckpoint === null) {
            /** @var UserLoggedInCheckpoint */
            $userLoggedInCheckpoint = $this->instanceManager->getInstance(UserLoggedInCheckpoint::class);
            $this->userLoggedInCheckpoint = $userLoggedInCheckpoint;
        }
        return $this->userLoggedInCheckpoint;
    }
    final public function setBooleanScalarTypeResolver(BooleanScalarTypeResolver $booleanScalarTypeResolver): void
    {
        $this->booleanScalarTypeResolver = $booleanScalarTypeResolver;
    }
    final protected function getBooleanScalarTypeResolver(): BooleanScalarTypeResolver
    {
        if ($this->booleanScalarTypeResolver === null) {
            /** @var BooleanScalarTypeResolver */
            $booleanScalarTypeResolver = $this->instanceManager->getInstance(BooleanScalarTypeResolver::class);
            $this->booleanScalarTypeResolver = $booleanScalarTypeResolver;
        }
        return $this->booleanScalarTypeResolver;
    }

    /**
     * @return array<class-string<ObjectTypeResolverInterface>>
     */
    public function getObjectTypeResolverClassesToAttachTo(): array
    {
        return [
            RootObjectTypeResolver::class,
        ];
    }

    /**
     * @return string[]
     */
    public function getFieldNamesToResolve(): array
    {
        /** @var EngineModuleConfiguration */
        $engineModuleConfiguration = App::getModule(EngineModule::class)->getConfiguration();
        $disableRedundantRootTypeMutationFields = $engineModuleConfiguration->disableRedundantRootTypeMutationFields();
        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        $addFieldsToQueryPayloadableCategoryMutations = $moduleConfiguration->addFieldsToQueryPayloadableCategoryMutations();
        return array_merge(
            [
                'createPostCategory',
                'createPostCategories',
            ],
            !$disableRedundantRootTypeMutationFields ? [
                'updatePostCategory',
                'updatePostCategories',
                'deletePostCategory',
                'deletePostCategories',
            ] : [],
            $addFieldsToQueryPayloadableCategoryMutations ? [
                'createPostCategoryMutationPayloadObjects',
            ] : [],
            $addFieldsToQueryPayloadableCategoryMutations && !$disableRedundantRootTypeMutationFields ? [
                'updatePostCategoryMutationPayloadObjects',
                'deletePostCategoryMutationPayloadObjects',
            ] : [],
        );
    }

    public function getFieldDescription(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?string
    {
        return match ($fieldName) {
            'createPostCategory' => $this->__('Create a post category', 'category-mutations'),
            'createPostCategories' => $this->__('Create post categories', 'category-mutations'),
            'updatePostCategory' => $this->__('Update a post category', 'category-mutations'),
            'updatePostCategories' => $this->__('Update post categories', 'category-mutations'),
            'deletePostCategory' => $this->__('Delete a post category', 'category-mutations'),
            'deletePostCategories' => $this->__('Delete post categories', 'category-mutations'),
            'createPostCategoryMutationPayloadObjects' => $this->__('Retrieve the payload objects from a recently-executed `createPostCategory` mutation', 'category-mutations'),
            'updatePostCategoryMutationPayloadObjects' => $this->__('Retrieve the payload objects from a recently-executed `updatePostCategory` mutation', 'category-mutations'),
            'deletePostCategoryMutationPayloadObjects' => $this->__('Retrieve the payload objects from a recently-executed `deletePostCategory` mutation', 'category-mutations'),
            default => parent::getFieldDescription($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): int
    {
        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        $usePayloadableCategoryMutations = $moduleConfiguration->usePayloadableCategoryMutations();
        if (!$usePayloadableCategoryMutations) {
            return match ($fieldName) {
                'createPostCategory',
                'updatePostCategory',
                'deletePostCategory'
                    => SchemaTypeModifiers::NONE,
                'createPostCategories',
                'updatePostCategories',
                'deletePostCategories'
                    => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY,
                default
                    => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
            };
        }

        if (
            in_array($fieldName, [
            'createPostCategoryMutationPayloadObjects',
            'updatePostCategoryMutationPayloadObjects',
            'deletePostCategoryMutationPayloadObjects',
            ])
        ) {
            return $this->getMutationPayloadObjectsFieldTypeModifiers();
        }

        return match ($fieldName) {
            'createPostCategory',
            'updatePostCategory',
            'deletePostCategory'
                => SchemaTypeModifiers::NON_NULLABLE,
            'createPostCategories',
            'updatePostCategories',
            'deletePostCategories'
                => SchemaTypeModifiers::NON_NULLABLE | SchemaTypeModifiers::IS_ARRAY | SchemaTypeModifiers::IS_NON_NULLABLE_ITEMS_IN_ARRAY,
            default
                => parent::getFieldTypeModifiers($objectTypeResolver, $fieldName),
        };
    }

    /**
     * @return array<string,InputTypeResolverInterface>
     */
    public function getFieldArgNameTypeResolvers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): array
    {
        return match ($fieldName) {
            'createPostCategory' => [
                'input' => $this->getRootCreateCategoryTermInputObjectTypeResolver(),
            ],
            'createPostCategories'
                => $this->getBulkOperationFieldArgNameTypeResolvers($this->getRootCreateCategoryTermInputObjectTypeResolver()),
            'updatePostCategory' => [
                'input' => $this->getRootUpdateCategoryTermInputObjectTypeResolver(),
            ],
            'updatePostCategories'
                => $this->getBulkOperationFieldArgNameTypeResolvers($this->getRootUpdateCategoryTermInputObjectTypeResolver()),
            'deletePostCategory' => [
                'input' => $this->getRootDeleteCategoryTermInputObjectTypeResolver(),
            ],
            'deletePostCategories'
                => $this->getBulkOperationFieldArgNameTypeResolvers($this->getRootDeleteCategoryTermInputObjectTypeResolver()),
            'createPostCategoryMutationPayloadObjects',
            'updatePostCategoryMutationPayloadObjects',
            'deletePostCategoryMutationPayloadObjects'
                => $this->getMutationPayloadObjectsFieldArgNameTypeResolvers(),
            default
                => parent::getFieldArgNameTypeResolvers($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldArgTypeModifiers(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName, string $fieldArgName): int
    {
        if (
            in_array($fieldName, [
            'createPostCategoryMutationPayloadObjects',
            'updatePostCategoryMutationPayloadObjects',
            'deletePostCategoryMutationPayloadObjects',
            ])
        ) {
            return $this->getMutationPayloadObjectsFieldArgTypeModifiers($fieldArgName)
                ?? parent::getFieldArgTypeModifiers($objectTypeResolver, $fieldName, $fieldArgName);
        }

        if (
            in_array($fieldName, [
            'createPostCategories',
            'updatePostCategories',
            'deletePostCategories',
            ])
        ) {
            return $this->getBulkOperationFieldArgTypeModifiers($fieldArgName)
                ?? parent::getFieldArgTypeModifiers($objectTypeResolver, $fieldName, $fieldArgName);
        }

        return match ([$fieldName => $fieldArgName]) {
            ['createPostCategory' => 'input'],
            ['updatePostCategory' => 'input'],
            ['deletePostCategory' => 'input']
                => SchemaTypeModifiers::MANDATORY,
            default => parent::getFieldArgTypeModifiers($objectTypeResolver, $fieldName, $fieldArgName),
        };
    }

    public function getFieldArgDefaultValue(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName, string $fieldArgName): mixed
    {
        if (
            in_array($fieldName, [
            'createPostCategories',
            'updatePostCategories',
            'deletePostCategories',
            ])
        ) {
            return $this->getBulkOperationFieldArgDefaultValue($fieldArgName)
                ?? parent::getFieldArgDefaultValue($objectTypeResolver, $fieldName, $fieldArgName);
        }

        return parent::getFieldArgDefaultValue($objectTypeResolver, $fieldName, $fieldArgName);
    }

    public function getFieldMutationResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ?MutationResolverInterface
    {
        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        $usePayloadableCategoryMutations = $moduleConfiguration->usePayloadableCategoryMutations();
        return match ($fieldName) {
            'createPostCategory' => $usePayloadableCategoryMutations
                ? $this->getPayloadableCreatePostCategoryTermMutationResolver()
                : $this->getCreatePostCategoryTermMutationResolver(),
            'createPostCategories' => $usePayloadableCategoryMutations
                ? $this->getPayloadableCreatePostCategoryTermBulkOperationMutationResolver()
                : $this->getCreatePostCategoryTermBulkOperationMutationResolver(),
            'updatePostCategory' => $usePayloadableCategoryMutations
                ? $this->getPayloadableUpdatePostCategoryTermMutationResolver()
                : $this->getUpdatePostCategoryTermMutationResolver(),
            'updatePostCategories' => $usePayloadableCategoryMutations
                ? $this->getPayloadableUpdatePostCategoryTermBulkOperationMutationResolver()
                : $this->getUpdatePostCategoryTermBulkOperationMutationResolver(),
            'deletePostCategory' => $usePayloadableCategoryMutations
                ? $this->getPayloadableDeletePostCategoryTermMutationResolver()
                : $this->getDeletePostCategoryTermMutationResolver(),
            'deletePostCategories' => $usePayloadableCategoryMutations
                ? $this->getPayloadableDeletePostCategoryTermBulkOperationMutationResolver()
                : $this->getDeletePostCategoryTermBulkOperationMutationResolver(),
            default => parent::getFieldMutationResolver($objectTypeResolver, $fieldName),
        };
    }

    public function getFieldTypeResolver(ObjectTypeResolverInterface $objectTypeResolver, string $fieldName): ConcreteTypeResolverInterface
    {
        /** @var ModuleConfiguration */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        $usePayloadableCategoryMutations = $moduleConfiguration->usePayloadableCategoryMutations();
        if ($usePayloadableCategoryMutations) {
            return match ($fieldName) {
                'createPostCategory',
                'createPostCategories',
                'createPostCategoryMutationPayloadObjects'
                    => $this->getRootCreatePostCategoryTermMutationPayloadObjectTypeResolver(),
                'updatePostCategory',
                'updatePostCategories',
                'updatePostCategoryMutationPayloadObjects'
                    => $this->getRootUpdatePostCategoryTermMutationPayloadObjectTypeResolver(),
                'deletePostCategory',
                'deletePostCategories',
                'deletePostCategoryMutationPayloadObjects'
                    => $this->getRootDeletePostCategoryTermMutationPayloadObjectTypeResolver(),
                default => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
            };
        }
        return match ($fieldName) {
            'createPostCategory',
            'createPostCategories',
            'updatePostCategory',
            'updatePostCategories'
                => $this->getPostCategoryObjectTypeResolver(),
            'deletePostCategory',
            'deletePostCategories'
                => $this->getBooleanScalarTypeResolver(),
            default
                => parent::getFieldTypeResolver($objectTypeResolver, $fieldName),
        };
    }

    /**
     * @return CheckpointInterface[]
     */
    public function getValidationCheckpoints(
        ObjectTypeResolverInterface $objectTypeResolver,
        FieldDataAccessorInterface $fieldDataAccessor,
        object $object,
    ): array {
        $validationCheckpoints = parent::getValidationCheckpoints(
            $objectTypeResolver,
            $fieldDataAccessor,
            $object,
        );

        /**
         * For Payloadable: The "User Logged-in" checkpoint validation is not added,
         * instead this validation is executed inside the mutation, so the error
         * shows up in the Payload
         *
         * @var ModuleConfiguration
         */
        $moduleConfiguration = App::getModule(Module::class)->getConfiguration();
        $usePayloadableCategoryMutations = $moduleConfiguration->usePayloadableCategoryMutations();
        if ($usePayloadableCategoryMutations) {
            return $validationCheckpoints;
        }

        switch ($fieldDataAccessor->getFieldName()) {
            case 'createPostCategory':
            case 'createPostCategories':
            case 'updatePostCategory':
            case 'updatePostCategories':
            case 'deletePostCategory':
            case 'deletePostCategories':
                $validationCheckpoints[] = $this->getUserLoggedInCheckpoint();
                break;
        }
        return $validationCheckpoints;
    }

    public function resolveValue(
        ObjectTypeResolverInterface $objectTypeResolver,
        object $object,
        FieldDataAccessorInterface $fieldDataAccessor,
        ObjectTypeFieldResolutionFeedbackStore $objectTypeFieldResolutionFeedbackStore,
    ): mixed {
        $fieldName = $fieldDataAccessor->getFieldName();
        switch ($fieldName) {
            case 'createPostCategoryMutationPayloadObjects':
            case 'updatePostCategoryMutationPayloadObjects':
            case 'deletePostCategoryMutationPayloadObjects':
                return $this->resolveMutationPayloadObjectsValue(
                    $objectTypeResolver,
                    $fieldDataAccessor,
                );
        }

        return parent::resolveValue($objectTypeResolver, $object, $fieldDataAccessor, $objectTypeFieldResolutionFeedbackStore);
    }
}
