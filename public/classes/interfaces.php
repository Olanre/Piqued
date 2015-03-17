<?php
/*********************************************
**  @Filename : Interfaces
*	@Description : This declares all the interfaces used by my system
*	@author : Olanrewaju Okunlola
*	@Date	: 2014-07-04
**********************************************/


/***************************************************************
	Our system can add follows to various objects such as an event
	a group, a user, a comment or to follow incidents happening in 
	a geographical location. To do this I have designated it as an
	interface that the respective class will implement if needed
******************************************************************/

interface Follow{
	#Where $entity represents the abstract object to be operated on
	protected function getfollowers($entity);
	
	#Where $entity represents the abstract object to be operated on
	#and child is the collection of new followers
	protected function setfollowers($entity, $child);
	
	#Where the $parent is the entity to be followed and the $child is the follower
	protected function setfollower( $parent, $child);
	
	#Where $parent is the entity to have its child removed
	protected function removefollower( $parent, $child);
	
	#Possibly used in the case that an entity needs to have its 
	#visible followers removed
	protected function removefollowers($entity);
	
	#To be used to get all parent objects following this child
	protected function getfollowing($child);
		
}

/***********************************
	Interface for determining the type
	of relationship governing this
	mutual bond
*/
interface FollowType{
	
	#To be used to determine of the type of relationship the 
	#parent - child bond is
	protected function getFollowTypes();
	
	#To be used to set the type of relationship
	protected function setFollowType( $type);
	
	#Set to filter the follow type based on parameters given
	protected function filterFollowType( $entity, $parameters);

}

/* ---------------------------------------------------------------------------------------------------------------------------------------- */


/*******************************************************************************
	Our system can does manipulations based on a concept of a 'tagmark'
	this 'tagmark' object has unique attributes that can be assigned to it
	however for data storage purposes it is not strictly defined to have
	a pre-determined set of attributes. 
	Manipulation of any tagmark object will require some general methods
	the behaviour of these methods will be determined by the class structure
	implementing this interface
	
********************************************************************************/
interface Tagmark{
	#Slightly fuzzy method to get a tagmark based on an identifier. 
	# This identifier could include be an array of identifier
	protected function getTag( $identifier );
	
	#Slightly fuzzy method to get a tagmark based on an identifier. 
	# This identifier could include be an array of identifier
	protected function getTags( $identifier);
	
	#Slightly fuzzy method to get a tagmarks for an entity
	#based on given search_descriptors. 
	protected function getTags( $entity , $search_descriptors );
	
	#Retrieves the attributes of a given tagmark
	public function getAttributes( $tagmark );
	
	#Sets the attribute of any tagmark
	public setAttribute( $attribute, $value, $tagmark );
	
	#Set an entity as a attribute list for the tagmark
	public setAttributes( $entity, $tagmark );
	
	#Get the type of a given tagmark
	public function getType( $tagmark );
	
	#Get the type of a given tagmark
	public function setType( $type , $tagmark );
	
	#Slightly fuzzy but a tagmark can be posted but its 
	#behavior upon posting will depend on the usage
	$public function addTagmark ($tagmark);
	
	#Slightly fuzzy but a tagmark can be removed but its 
	#behavior upon posting will depend on the usage
	$public function removeTagmark ($tagmark);
	
	#get the unique identifier from a given tagmark
	public function getTagmarkId( $tagmark );
}

# This interface is to be used solely by the manipulating object itself
interface ObjectTagmark{
	
	#Get the tagmark type
	protected function getType();
	
	#Set the tagmark type 
	protected function setType( $type);
	
	#Retrieves the attributes of a given tagmark by the object instance itself
	protected function getAttributes();
	
	#Sets the attribute to be used by the object instance
	protected setAttribute( $attribute , $value );
	
	#Set an entity as a attribute list for the object instance
	protected setAttributes( $entity );
	
	#get the unique identifier from the tagmark
	protected function getId();

}

/*********************************************
	Interfaces to handle more specific methods
	related to the tagmarks
*/

interface TagMarkLocation{

	#Check if the tagmark type matches the one needed for
	#this method
	protected function getCheckType($tagmark);

	#Get tagmarks around a particular location
	protected function getTagsByLocation( $location);
	
	#filter a list of tags
	protected function filterTags( $list);
	
	#filter the location by some parameters
	protected function filterLocation( $location, $parameters);

}


/* ------------------------------------------------------------------------------------------------------------------------------------ */


/**************************************************************************
	This interface deals with all the methods any group object or class
	managing a group should be capable of doing. This includes adding
	objects as subscribers of that group, adding a Tagmark, tweaking with
	settings and so forth.
***************************************************************************/
interface Group {
	#Add a new subscriber to the group, an abstract entity
	#but normally a user
	protected function addSubscriber($group , $entity);
	
	#remove a subscribing entity from a given group
	public function removeSubscriber($group, $entity);
	
	#remove a list of subscribing entities to a given group
	public function removeSubscribers ( $group, $entities);
	
	#locate a group given a unique identifier
	public function getGroup( $identifier );
	
	#function to add a group
	public function addGroup( $group);
	
	#function to remove a group
	public function removeGroup($group);
	
	#function to get all the entities subscribed to a group
	public function getSubscribers( $group);
	
	#function to set a list of subscribers for a group
	public function setSubscribers( $entities );
	
}

#list of methods to be implemented by instance object
interface ObjectGroup {

	#Add a new subscriber to the group, an abstract entity
	#but normally a user
	protected function addSubscriber($entity);
	
	#remove a subscribing entity from a given group
	protected function removeSubscriber($entity);
	
	#remove a list of subscribing entities to a given group
	protected function removeSubscribers ( $entities);
	
	#function to get all the entities subscribed to a group
	protected function getSubscribers();

}

/***************************************
	Interface for handling requests to subscribe 
	to a group
*/
interface GroupRequest{

	#Add a request for a group
	public function GroupRequest( $group, $user);
	
	#remove a request for a group
	public function RequestRemove( $group, $user);
	
	#Get all active requests for a group
	public function AllRequestsGroup( $group);
	

}

/** ---------------------------------------------------------------------------------------------------------------------------------------------- */

/*********************************************************
	This interface or group of them are related to users
	since most of the attributes for a user are not predefined
	any class implementing this interface will have its own 
	unique way of handling the methods for creating, modifying
	and manipulation the user
	
***********************************************************/

interface UserService{

	#Log in the user with the given username, password and 
	# their unique identifier
	protected function login();
	
	#Log out the user with the given unqiue id
	protected function logout();
	
	#Get a user given an identifier
	protected function getUser();
	
	
	#Check if a given user exists in the database given a username
	protected function checkUsername ();
	
	#Check if an email account given is valid
	protected function checkEmail ();
	
	#check the credentials of a user
	protected function checkCredentials();
	
	#check the credentials of a user
	protected function checkAttempts();
	
} 

/*********************************
	This interface is for dealing with 
	all things related to the attributes
	related to that user
*/

interface UserAttributes{
	
	#set the attributes of a user
	protected function setAttributes ( $attributes);
	
	#get the attributes of a user based on their type
	protected function getAttributes ( $type);
	
	#Get base attributes of a user, not related to their type
	protected function getDefaultAttributes();
	
	protected function setDefaultAttributes( $attributes );
	
	#function to get a specific attribute value by name 
	protected function getAttribute( $name);
	
	
}

/*****************************************
	This interface is for methods
	to be executed by the object instance
******************************************/
interface UserObject{
	
	#function to get the username
	protected function getUserName();

	#function to set the username
	protected function setUserName( $username );
	
	#function to get the password
	protected function getPassword();
	
	#function to set the password
	protected function setPassword( $password);
	
	#function to get the email address
	protected function getEmail();
	
	#function to set the email address
	protected function setEmail($address);
	
	#function to get the location
	protected function getLocation();
	
	#function to set the location
	protected function setLocation( $location);
	
	#function to get the Age of the Individual
	protected function getAge();
	
	#function to set the age of the individual
	protected function setAge( $age);
	
	#function to get the sex of the individual
	protected function getSex();
	
	#function to set the sex of the individual
	protected function setSex( $sex);
	
	#functiont to get the user Type
	protected function getType();
	
	#function to set the user type
	protected function setType($type);
	
	#function to get the id of the user
	protected function getUserId();
		
}

interface UserLocal{

	#function to get the join date of the user
	protected function getJoinDate( $user);
	
	#function to get local users within a location
	protected function getLocalUsers ($location);
	
	#filter the users based on a filter
	protected function filterUsers ($list, $parameters);
	
	#filter the user for some information
	protected function filterUser( $list);

}

/*************************
Deprecated: awaiting removal

****************************
interface UserIndividual extends UserObject{

	#function to get the timezone
	protected function getTimeZone();
	
	#function to set the timezone
	protected function setTimeZone( $timezone);
	
	#function to get the phone number
	protected function getPhone();
	
	#function to set the phone number
	protected function setPhone( $number );
	
	#function to get the default location
	protected function getDefaultLocation();
	
	#function to set the default location
	protected function setDefaultLocation();
	
	#function to get the interests of the individual
	protected function getInterests();
	
	#function to set the interests of the individual
	protected function setInterests($interests);
	
	#function to get the description of the individual
	protected function getDescription();
	
	#function to set the description of the user
	protected function setDescription( $description);	

}
*/

/***************************************************
	Interface dealing with the actual account 
	of the user
*/
interface Account {
	public function createAccount( $user);
	
	public function deleteAccount( $user);
	
	public function accountCreationDate( $user);
	
	public function lastLogin( $user );
	
	public function getSettings();
	
}

/* -------------------------------------------------------------------------------------------------------------------------------------  */

/*************************************************
	Interfaces for filters and sorting methods
	to be used by various classes
*/

interface Filtering{
	
	#Given a list, filter the list using the parameters
	#provided
	protected function FilterList(  $list, $parameters);
	
	#Given an entity perform filters upon it
	protected function FilterEntity( $entity);

}

interface Sorting{
	
	#given a list of entities sort it based on a parameters
	protected function SortList( $list, $parameters);
	
	#given a List perform a sort on it
	protected function Sort($list);
	
}

interface Comparator{

	#compare two entities
	protected function Compare( $a, $b);
	
	#match an entity against a list
	protected function cmp_to_list($entity, $list);

}

/** ---------------------------------------------------------------------------------------------------------------------------------- */

/***************************************************
	Interface related to manipulation of out view
	the view would normally be a map but may differ
*/

interface View{

	#function to get the bounds of the current view
	protected function getBounds();
	
	#function to set the bounds of the view
	protected function setBounds( $x, $y, $w, $h);
	
	#function to get any overlays over the current view
	protected function getOverlay();
	
	#function to set an overlay layer over the current view
	protected function setOverlay( $layer);
	
	#function to remove a particular overlay from the view
	protected function removeOverlay( $layer);
	
	#Function to set an attribute for the current view
	protected function setAttribute( $Attribute);
	
	#function to get the attributes for the view
	protected function getAttributes();
	
	#function to get the events of the current view
	protected function getEvents();
	
	#function to add an event to the current view
	protected function addEvent( $event);
	
}

/*	------------------------------------------------------------------------------------------------------------------------------------------------- */

/*******************************************************
	Interface to handle any methods related to a Database
	The database used will be primarily MySQL but other
	types of connections can be used, as determined
	by the class implementing the database interface
*/
interface Database{
	
	#function to archive a data row - deleting does not exist in the system
	public function archive( $table, $id);
	
	#function to insert data into the table, fields are the columns to be
	#assigned the values
	public function insert($table, $fields, $data);
	
	#connect to the database driver
	public function connect();
	
	#disconnect from the database c
	public function disconnect();
	
	#delete a specific row given by a column and its value
	public function archiveSpecific( $table, $idname, $idval);
	
	#get the last row in a table
	public function getLastRow($table);
	
	#prepare a query for execution
	public function prepareStatement( $string);
	
	#execute a prepared query
	private function executePreparedStatement( $resource, $fields, $values);
	
	#get the results of the query but in an associative array
	public function fetchRowAssoc();
	
	#get the id of the last insert row
	public function lastId();
	
	#get the number of rows affected in the last sql execution
	public function numRows();
	
	#get the preferred database driver
	public function getDrvier( );

}

/** ---------------------------------------------------------------------------------------------------------------------------------------------------- */

/*******************************************
	Interface to deal with connections 
	to a server, falling over to another
	server for execution and allowing
	a user to connect or disconnect to
	the system
******************************************/
	interface NETServer{
		
		#add a user to the list of active users connected to this server
		protected function addActiveUser( $user);
		
		#removes a user from the list of active users connected to this server
		protected function removeActiveUser( $user);
		
		#gets a list of all active users connected to this server
		protected function getActiveUsers();
		
		#redirects a connection resource to another server
		protected function redirectToServer( $resource, $server_ip, $server_port);
		
		#allows it to recieve a resource from another ip address
		protected function receivefromServer( $ip, $resource);
		
		#checks how many active users are currently connected
		protected function checkActiveUsers();
		
		#calls a function on the user end through am RMI call with its own parameters
		protected function RemoveMethodInvoc( $function, $user, $parameters);
		
		#get the ip address of a particular user
		protected function getIPAddress( $user);
		
		#get the port number of a particular user
		protected function getPortNumber( $user);
		
		#set the port number for a user
		protected function setPortNumber( $user, $portnumber);
		
		#set the ip address for a particular user
		protected function setIPAddress( $user, $ip);
		
		#RMI call to all active users, broadcast to a function call with parameters
		protected function BroadCast($callback, $parameters);
	}


?>