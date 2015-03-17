<?php 
class Tagmark{

	#Instance variables
	private $tags;
    private $SqlEngine; 
    private $ERROR   = "Generic error for TagMark class, method: "; 

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
?>
