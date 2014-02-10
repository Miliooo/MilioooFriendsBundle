<?php

namespace Miliooo\Friends\Checker;

use Miliooo\Friends\Provider\UserRelationshipsProviderInterface;


class RelationshipChecker
{
    protected $relationshipProvider;

    /**
     * @param UserRelationshipProviderInterface $relationshipProvider
     */
    public function __construct(UserRelationshipProviderInterface $relationshipProvider)
    {
        $this->relationshipProvider = $relationshipProvider;
    }

}
