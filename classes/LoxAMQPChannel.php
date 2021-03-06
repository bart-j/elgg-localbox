<?php
/**
 * AMQP Channel connection
 *
 * @package Localbox
 */

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class LoxAMQPChannel {

  protected $connection = null;
  protected $channel = null;

  public function __construct() {
    global $CONFIG;

    try {
      $this->connection = new AMQPConnection($CONFIG->amqp_host, 5672, $CONFIG->amqp_user, $CONFIG->amqp_pass, $CONFIG->amqp_vhost);
      $this->channel = $this->connection->channel();
      $this->channel->queue_declare($CONFIG->amqp_lox_queue, false, true, false, false);
    } catch (Exception $exception) {
      $this->connection = false;
    }

  }

  public function publishMessage($data) {
    global $CONFIG;

    if ($this->connection) {
      $message = new AMQPMessage($data);
      return $this->channel->basic_publish($message, '', $CONFIG->amqp_lox_queue);
    }
  }

}
