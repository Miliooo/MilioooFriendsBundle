<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Controller;

use Miliooo\Friends\Provider\UserRelationshipsProviderInterface;
use Miliooo\Friends\User\UserRelationshipTransformerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class ShowFriendsController
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class ShowFriendsController
{
    /**
     * @var UserRelationshipTransformerInterface
     */
    private $transformer;

    /**
     * @varUserRelationshipsProviderInterface
     */
    private $userRelationshipsProvider;

    /**
     * Constructor.
     *
     * @param UserRelationshipTransformerInterface $transformer
     * @param UserRelationshipsProviderInterface   $userRelationshipsProvider
     */
    public function __construct(
        UserRelationshipTransformerInterface $transformer,
        UserRelationshipsProviderInterface $userRelationshipsProvider
    ) {
        $this->transformer = $transformer;
        $this->userRelationshipsProvider = $userRelationshipsProvider;
    }

    /**
     * Gets the followers for the given user.
     *
     * @param mixed $userRelationshipId
     *
     * @return JsonResponse
     */
    public function getFollowersAction($userRelationshipId)
    {
        $user = $this->transformer->transformToObject($userRelationshipId);
        $followers = $this->userRelationshipsProvider->getFollowers($user);

        return new JsonResponse(['data' => $followers]);
    }
}
