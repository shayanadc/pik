<?php
/**
 * Created by PhpStorm.
 * User: shayanadc
 * Date: 12/3/17
 * Time: 5:07 PM
 */

namespace App;


class UserGroupBoundary
{
    static function addUsersToGroup($groupId,$userIds){
        $group = Group::findOrFail($groupId);
        return $group->users()->attach($userIds);
    }
    static function getGroups($userId){
        $user = User::findOrFail($userId);
        return $user->groups;
    }

}