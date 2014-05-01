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
use Miliooo\Friends\User\UserIdentifierInterface;
use Miliooo\Friends\User\UserRelationshipTransformerInterface;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

/**
 * Class ShowFriendsController
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class ShowFriendsController
{
    /**
     * An user relationship transformer instance.
     *
     * @var UserRelationshipTransformerInterface
     */
    private $transformer;

    /**
     * An user relationship provider instance.
     *
     * @varUserRelationshipsProviderInterface
     */
    private $userRelationshipsProvider;

    /**
     * A templating instance.
     *
     * @var \Symfony\Bundle\FrameworkBundle\Templating\EngineInterface
     */
    private $templating;

    /**
     * Constructor.
     *
     * @param UserRelationshipTransformerInterface $transformer
     * @param UserRelationshipsProviderInterface   $userRelationshipsProvider
     * @param EngineInterface                      $templating
     */
    public function __construct(
        UserRelationshipTransformerInterface $transformer,
        UserRelationshipsProviderInterface $userRelationshipsProvider,
        EngineInterface $templating
    ) {
        $this->transformer = $transformer;
        $this->userRelationshipsProvider = $userRelationshipsProvider;
        $this->templating = $templating;
    }

    /**
     * Shows an overview for the relationships for a given user.
     *
     * @param string $userRelationshipId
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showAction($userRelationshipId)
    {
        $user = $this->getUser($userRelationshipId);

        $userRelationships = $this->userRelationshipsProvider->getUserRelationships($user);

        return $this->templating->renderResponse('MilioooFriendsBundle:Friends:user_relationship_overview.html.twig', ['userRelationships' => $userRelationships]);
    }

    /**
     * Gets the user.
     *
     * @param string $userRelationshipId
     *
     * @return UserIdentifierInterface
     */
    protected function getUser($userRelationshipId)
    {
        return $this->transformer->transformToObject($userRelationshipId);
    }
}
