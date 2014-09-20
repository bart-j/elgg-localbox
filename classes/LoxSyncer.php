<?php
/**
 * Localbox synchronizer
 *
 * @package Localbox
 */

class LoxSyncer {
  protected $channel = null;

  public function __construct() {
    $this->channel = new LoxAMQPChannel();
  }

  public function updateUser(ElggUser $user) {
    $data = array(
      'type' => 'user',
      'guid' => $user->username . '@www.pleio.nl',
      'name' => $user->name,
      'email' => $user->email,
      'action' => 'update'
    );

    return $this->channel->publishMessage(json_encode($data));
  }

  public function deleteUser(ElggUser $user) {
    $data = array(
      'type' => 'user',
      'guid' => $user->username . '@www.pleio.nl',
      'action' => 'delete'
    );

    return $this->channel->publishMessage(json_encode($data));
  }

  public function updateGroup(ElggEntity $entity) {
    
    if ($entity instanceof ElggGroup) {
      $site = get_entity($entity->site_guid);
      $name = $site->name . ", " . $entity->name;
    } else {
      $name = $entity->name;
    }

    $data = array(
      'type' => 'group',
      'guid' => $entity->guid,
      'name' => $name,
      'action' => 'update'
    );

    return $this->channel->publishMessage(json_encode($data));    
  }

  public function deleteGroup(ElggEntity $entity) {

    $data = array(
      'type' => 'group',
      'guid' => $entity->guid,
      'action' => 'delete'
    );

    return $this->channel->publishMessage(json_encode($data));  
  }

  public function addUserToGroup(ElggUser $user, ElggEntity $group) {

    $data = array( 
      'type' => 'user_group',
      'user_guid' => $user->username . '@www.pleio.nl',
      'group_guid' => $group->guid,
      'action' => 'add'
    );

    return $this->channel->publishMessage(json_encode($data));  
  }

  public function deleteUserFromGroup(ElggUser $user, ElggEntity $group) {

    $data = array( 
      'type' => 'user_group',
      'user_guid' => $user->username . '@www.pleio.nl',
      'group_guid' => $group->guid,
      'action' => 'delete'
    );

    return $this->channel->publishMessage(json_encode($data));  
  }

}