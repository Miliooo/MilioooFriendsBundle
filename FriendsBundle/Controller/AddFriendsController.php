<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Controller;

use Miliooo\Friends\User\LoggedInUserProviderInterface;
use Miliooo\Friends\User\UserRelationshipTransformerInterface;
use Miliooo\Friends\ValueObjects\UserRelationship;
use Miliooo\Friends\Exceptions\FriendException;
use Miliooo\Friends\Exceptions\IdenticalFollowerFollowedException;
use Symfony\Component\HttpFoundation\Response;
use Miliooo\Friends\Command\Handler\CreateRelationshipCommandHandlerInterface;
use Miliooo\Friends\Command\CreateRelationshipCommand;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This controller is responsible for adding friends.
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class AddFriendsController
{
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
     * @param CreateRelationshipCommandHandlerInterface $handler
     * @param LoggedInUserProviderInterface             $userProvider
     * @param UserRelationshipTransformerInterface      $transformer
     */
    public function __construct(
        CreateRelationshipCommandHandlerInterface $handler,
        LoggedInUserProviderInterface $userProvider,
        UserRelationshipTransformerInterface $transformer
    ) {
        $this->handler = $handler;
        $this->userProvider = $userProvider;
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
        } catch (FriendException $e) {
            if ($e instanceof IdenticalFollowerFollowedException) {
                $data['error'] = true;
            } else {
               $data['error'] = true;
            }
            //since we don't have a valid user relationship object we need to return here.
            return new JsonResponse($data);
        }

        $command = new CreateRelationshipCommand();
        $command->setDateCreated(new \DateTime('now'));
        $command->setUserRelationship($userRelationship);

        try {
            $this->handler->handle($command);
        } catch (\Exception $e) {
            $data['error'] = true;
        }

        $data['success'] = true;

        return new JsonResponse($data);
    }
}
