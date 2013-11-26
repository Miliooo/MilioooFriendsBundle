<?php

/*
* This file is part of the MilioooFriendsBundle package.
*
* (c) Michiel boeckaert <boeckaert@gmail.com>
* This source file is subject to the MIT license that is bundled
* with this source code in the file LICENSE.
*/

namespace Miliooo\FriendsBundle\Entity;

use Miliooo\Friends\Model\Relationship as BaseRelationship;

/**
 * Relationship model
 *
 * @author Michiel Boeckaert <boeckaert@gmail.com>
 */
class Relationship extends BaseRelationship
{
    protected $id;
}
