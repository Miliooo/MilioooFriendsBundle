<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Controller;

use Miliooo\Friends\Creator\RelationshipCreatorInterface;
use Miliooo\Friends\User\LoggedInUserProviderInterface;
use Miliooo\Friends\User\UserRelationshipTransformerInterface;
use Miliooo\Friends\ValueObjects\UserRelationship;
use Miliooo\Friends\Exceptions\FriendException;
use Miliooo\Friends\Exceptions\IdenticalFollowerFollowedException;
use Symfony\Component\HttpFoundation\Response;

/**
 * This controller is responsible for adding friends.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class AddFriendsController
{
    /**
     * A relationship creator instance.
     *
     * @var RelationshipCreatorInterface
     */
    protected $relationshipCreator;

    /**
     * A logged in user provider instance.
     *
     * @var LoggedInUserProviderInterface
     */
    protected $userProvider;

    /**
     * An userRelationshipTransformer instance.
     *
     * @var UserRelationshipTransformerInterface
     */
    protected $transformer;

    /**
     * Constructor.
     *
     * @param RelationshipCreatorInterface         $relationshipCreator
     * @param LoggedInUserProviderInterface        $userProvider
     * @param UserRelationshipTransformerInterface $transformer
     */
    public function __construct(
        RelationshipCreatorInterface $relationshipCreator,
        LoggedInUserProviderInterface $userProvider,
        UserRelationshipTransformerInterface $transformer
    ) {
        $this->userProvider = $userProvider;
        $this->relationshipCreator = $relationshipCreator;
        $this->transformer = $transformer;
    }

    /**
     * @param mixed $userRelationshipId
     *
     * @return Response
     */
    public function addFriendsAction($userRelationshipId)
    {
        $loggedInUser = $this->userProvider->getAuthenticatedUser();
        $followed = $this->transformer->transformToObject($userRelationshipId);

        try {
            $userRelationship = new UserRelationship($loggedInUser, $followed);
        } catch(FriendException $e) {
            if ($e instanceof IdenticalFollowerFollowedException) {
                return new Response('identical friends');
            } else {
                return new Response('unknown error');
            }
        }

        $this->relationshipCreator->createRelationship($userRelationship, new \DateTime('now'));

        return new Response('success');
    }
}
