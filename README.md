Pleio Localbox synchronisation
==============================
This plugin offers synchronisation of users, groups and subsites to Localbox through a RabbitMQ instance. When the plugin is enabled, deltas are send to Localbox. Also the plugin enables a Localbox widget that allows a user to access his Localbox instance.

Installation
------------
1. Make sure php5*-amqp is installed.
2. Enable the plugin localbox, and make sure the plugin is also enabled for all subsites.
3. Use the script to provision a full update.

Now the plugin automatically sends all deltas into RabbitMQ. Use the Pleio bundle in Localbox to process the queue.