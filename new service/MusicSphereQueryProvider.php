<?php
/** 
 * Implementation of IDataServiceQueryProvider.
 * 
 * PHP version 5.3
 * 
 * @category  Service
 * @package   WordPress
 * @author    Microsoft Open Technologies, Inc. <msopentech@microsoft.com>
 * @copyright Microsoft Open Technologies, Inc.
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   GIT: 1.2
 * @link      https://github.com/MSOpenTech/odataphpprod
 * All rights reserved.
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *  Redistributions of source code must retain the above copyright notice, this list
 *  of conditions and the following disclaimer.
 *  Redistributions in binary form must reproduce the above copyright notice, this
 *  list of conditions  and the following disclaimer in the documentation and/or
 *  other materials provided with the distribution.
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A  PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS
 * OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)  HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN
 * IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 */
use ODataProducer\UriProcessor\ResourcePathProcessor\SegmentParser\KeyDescriptor;
use ODataProducer\Providers\Metadata\ResourceSet;
use ODataProducer\Providers\Metadata\ResourceProperty;
use ODataProducer\Providers\Query\IDataServiceQueryProvider;
require_once "MusicSphereMetadata.php";
require_once "ODataProducer\Providers\Query\IDataServiceQueryProvider.php";
/** The name of the database for MusicSphere */
define('DB_NAME', 'musicsphere');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/**
 * WordPressQueryProvider implemetation of IDataServiceQueryProvider.
 * 
 * @category  Service
 * @package   MusicSphere
 * @author    Microsoft Open Technologies, Inc. <msopentech@microsoft.com>
 * @copyright Microsoft Open Technologies, Inc.
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   GIT: 1.2
 * @link      https://github.com/MSOpenTech/odataphpprod
 */
class MusicSphereQueryProvider implements IDataServiceQueryProvider
{
    /**
     * Handle to connection to Database     
     */
    private $_connectionHandle = null;

    /**
     * Constructs a new instance of MusicSphereQueryProvider
     * 
     */
    public function __construct()
    {
        $this->_connectionHandle = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD, true);
        if ( $this->_connectionHandle ) {
        } else {             
             die(print_r(mysql_error(), true));
        } 

        mysql_select_db(DB_NAME, $this->_connectionHandle);
    }
    
    /**
     * Gets collection of entities belongs to an entity set
     * 
     * @param ResourceSet $resourceSet The entity set whose 
     * entities needs to be fetched
     * 
     * @return array(Object)
     */
    public function getResourceSet(ResourceSet $resourceSet)
    {   
        $resourceSetName =  $resourceSet->getName();
        if ($resourceSetName !== 'user' 
            && $resourceSetName !== 'registration' 
            && $resourceSetName !== 'song' 
            && $resourceSetName !== 'album' 
            && $resourceSetName !== 'artist'
			&& $resourceSetName !== 'favourites'
			&& $resourceSetName !== 'recentlyplayed'
			&& $resourceSetName !== 'rating'
        ) {
            die('(MusicSphereQueryProvider) Unknown resource set ' . $resourceSetName);
        }

       
        $returnResult = array();
        switch ($resourceSetName) {
        case 'user':
            $query = "SELECT * FROM user";
            $stmt = mysql_query($query);
            $returnResult = $this->_serializeUsers($stmt);
            break;
        case 'registration':
            $query = "SELECT * FROM registration";
            $stmt = mysql_query($query);
            $returnResult = $this->_serializeRegistrations($stmt);
            break;
		case 'song':
            $query = "SELECT * FROM song";
            $stmt = mysql_query($query);
            $returnResult = $this->_serializeSongs($stmt);
            break;
        case 'album':
            $query = "SELECT * FROM album";
            $stmt = mysql_query($query);
            $returnResult = $this->_serializeAlbums($stmt);
            break;
        case 'artist':
            $query = "SELECT * FROM artist";
            $stmt = mysql_query($query);
            $returnResult = $this->_serializeArtists($stmt);
            break;
        case 'favourites':
            $query = "SELECT * FROM favourites";
            $stmt = mysql_query($query);
            $returnResult = $this->_serializeFavourites($stmt);
            break;
		case 'rating':
            $query = "SELECT * FROM rating";
            $stmt = mysql_query($query);
            $returnResult = $this->_serializeRatings($stmt);
            break;
		case 'recentlyplayed':
            $query = "SELECT * FROM recentlyplayed";
            $stmt = mysql_query($query);
            $returnResult = $this->_serializeRecentlyPlayed($stmt);
            break;
        }
        
        mysql_free_result($stmt);
        return $returnResult;
    }
      
/**
     * Gets an entity instance from an entity set identifed by a key
     * 
     * @param ResourceSet   $resourceSet   The entity set from which an entity 
     *                                     needs to be fetched
     * @param KeyDescriptor $keyDescriptor The key to identify the entity 
     *                                     to be fetched
     * 
     * @return Object/NULL Returns entity instance if found else null
     */
    public function getResourceFromResourceSet(ResourceSet $resourceSet, KeyDescriptor $keyDescriptor)
    {   
        $resourceSetName =  $resourceSet->getName();
        if ($resourceSetName !== 'user' 
            && $resourceSetName !== 'registration' 
            && $resourceSetName !== 'song' 
            && $resourceSetName !== 'album' 
            && $resourceSetName !== 'artist'
        ) {
            die('(MusicSphereQueryProvider) Unknown resource set ' . $resourceSetName);
        }

        $namedKeyValues = $keyDescriptor->getValidatedNamedValues();
        $keys = array();
        foreach ($namedKeyValues as $key => $value) {
            $keys[] = "$key = '$value[0]' ";
        }
        $conditionStr = implode(' AND ', $keys);
        
        switch ($resourceSetName) {
        case 'user':
            $query = "SELECT * FROM user where id = ".$namedKeyValues['id'][0];
            $stmt = mysql_query($query);
              
            //If resource not found return null to the library
            if (!mysql_num_rows($stmt)) {
                return null;
            } 
              
            $data = mysql_fetch_assoc($stmt);
            $result = $this->_serializeUser($data);
            break;
        case 'registration':
            $query = "SELECT * from registration where id = ".$namedKeyValues['id'][0];
            $stmt = mysql_query($query);
              
            //If resource not found return null to the library
            if (!mysql_num_rows($stmt)) {
                return null;
            }
              
            $data = mysql_fetch_assoc($stmt);
            $result = $this->_serializeRegistration($data);
            break;
        case 'song':
            $query = "SELECT * FROM song where id = ".$namedKeyValues['id'][0];
            $stmt = mysql_query($query);
              
            //If resource not found return null to the library
            if (!mysql_num_rows($stmt)) {
                return null;
            }
              
            $data = mysql_fetch_assoc($stmt);
            $result = $this->_serializeSong($data);
            break;
        case 'album':
            $query = "SELECT * FROM album where id = ".$namedKeyValues['id'][0];
            $stmt = mysql_query($query);
              
            //If resource not found return null to the library
            if (!mysql_num_rows($stmt)) {
                return null;
            }
              
            $data = mysql_fetch_assoc($stmt);
            $result = $this->_serializeAlbum($data);
            break;
        case 'artist':
            $query = "SELECT * FROM artist WHERE id = ".$namedKeyValues['id'][0];
            $stmt = mysql_query($query);
              
            //If resource not found return null to the library
            if (!mysql_num_rows($stmt)) {
                return null;
            }
              
            $data = mysql_fetch_assoc($stmt);
            $result = $this->_serializeArtist($data);
            break;
        }
        
        mysql_free_result($stmt);
        return $result;
    }
    
    /**
     * Get related resource set for a resource
     * 
     * @param ResourceSet      $sourceResourceSet    The source resource set
     * @param mixed            $sourceEntityInstance The resource
     * @param ResourceSet      $targetResourceSet    The resource set of 
     *                                               the navigation property
     * @param ResourceProperty $targetProperty       The navigation property to be 
     *                                               retrieved
     *                                               
     * @return array(Objects)/array() Array of related resource if exists, if no 
     *                                related resources found returns empty array
     */
    public function  getRelatedResourceSet(ResourceSet $sourceResourceSet, 
        $sourceEntityInstance, 
        ResourceSet $targetResourceSet,
        ResourceProperty $targetProperty
    ) {    
        $result = array();
        $srcClass = get_class($sourceEntityInstance);
        $navigationPropName = $targetProperty->getName();
        
        switch (true) {
        case ($srcClass == 'user'):
            if ($navigationPropName == 'registration') {
                $query = "SELECT * FROM registration"
						 ." WHERE user = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                        
                $result = $this->_serializeRegistrations($stmt);
            } elseif ($navigationPropName == 'favourites') {
                $query = "SELECT * FROM favourites "
						 ."WHERE user = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {            
                       die(mysql_error());
                }
                        
                $result = $this->_serializeFavourites($stmt);
            } else if ($navigationPropName == 'recentlyplayed') {
                $query = "SELECT r.* FROM recentlyplayed r"
						 ." WHERE user = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                        
                $result = $this->_serializeRecentlyPlayed($stmt);
            } else {
                die('user does not have navigation property with name: ' . $navigationPropName);
            }
            break;

        case ($srcClass == 'registration'):
            if ($navigationPropName == 'user') {
                $query = "SELECT u.* FROM user u"
						." INNER JOIN registration r on r.user = u.id "
						." AND r.id = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                            die(mysql_error());
                }
                        
                      $result = $this->_serializeUsers($stmt);
            } else {
                die('registration does not have navigation property with name: ' . $navigationPropName);
            }
            break;
                    
        case ($srcClass == 'song'):
            if ($navigationPropName == 'album') {
                $query = "SELECT * FROM album"
						 ."WHERE song = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                        
                $result = $this->_serializeAlbums($stmt);
            } else if ($navigationPropName == 'artist') {
                $query = "SELECT * FROM artist"
						." WHERE song = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                        
                $result = $this->_serializeArtists($stmt);
            }
			else {
                die('artist does not have navigation property with name: ' . $navigationPropName);
            }
            break;
                 
        case ($srcClass == 'album'):
			if ($navigationPropName == 'song') {
                $query = "SELECT * FROM song "
                        ." WHERE album = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                            
                $result = $this->_serializeSongs($stmt);
            } else {
				die('album does not have navigation property with name: ' . $navigationPropName);
			}
            break;
                    
        case ($srcClass == 'artist'):
            if ($navigationPropName == 'song') {
                $query = "SELECT * FROM song"
                        ." WHERE artist = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                            
                $result = $this->_serializeSongs($stmt);
            }  else {
                die('artist does not have navigation property with name: ' . $navigationPropName);
            }
            break;
        }
        
        mysql_free_result($stmt);
        return $result;
    }
    
    /**
     * Gets a related entity instance from an entity set identifed by a key
     * 
     * @param ResourceSet      $sourceResourceSet    The entity set related to
     *                                               the entity to be fetched.
     * @param object           $sourceEntityInstance The related entity instance.
     * @param ResourceSet      $targetResourceSet    The entity set from which
     *                                               entity needs to be fetched.
     * @param ResourceProperty $targetProperty       The metadata of the target 
     *                                               property.
     * @param KeyDescriptor    $keyDescriptor        The key to identify the entity 
     *                                               to be fetched.
     * 
     * @return Object/NULL Returns entity instance if found else null
     */
    public function  getResourceFromRelatedResourceSet(ResourceSet $sourceResourceSet, 
        $sourceEntityInstance, 
        ResourceSet $targetResourceSet,
        ResourceProperty $targetProperty,
        KeyDescriptor $keyDescriptor
    ) {
        $result = array();
        $srcClass = get_class($sourceEntityInstance);
        $navigationPropName = $targetProperty->getName();
        
        $keys = array();
        $namedKeyValues = $keyDescriptor->getValidatedNamedValues();
        foreach ($namedKeyValues as $key => $value) {
            $keys[] = "$key = '$value[0]' ";
        }
        $conditionStr = implode(' AND ', $keys);
        
        switch (true) {
        case ($srcClass == 'user'):
            if ($navigationPropName == 'registration') {
				$query = "SELECT *" 
                         ." FROM registration"
						 ." WHERE user = ".$namedKeyValues['id'][0];
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                        
                $result = $this->_serializeRegistrations($stmt);
            } elseif ($navigationPropName == 'favourites') {
                $query = "SELECT * FROM favourites"
						 ." WHERE user = ".$namedKeyValues['id'][0];
                $stmt = mysql_query($query);
                if ( $stmt === false) {            
                       die(mysql_error());
                }
                        
                $result = $this->_serializeFavourites($stmt);
            } else if ($navigationPropName == 'recentlyplayed') {
                $query = "SELECT * FROM recentlyplayed"
						 ." WHERE user = ".$namedKeyValues['id'][0];
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                        
                $result = $this->_serializeRecentlyPlayed($stmt);
            } else {
                die('user does not have navigation property with name: ' . $navigationPropName);
            }
            break;

        case ($srcClass == 'registration'):
            if ($navigationPropName == 'user') {
                $query = "SELECT u.* FROM user u"
						." INNER JOIN registration r on r.user = u.id "
						." AND r.id = ".$namedKeyValues['id'][0];
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                            die(mysql_error());
                }
                        
                      $result = $this->_serializeUsers($stmt);
            } else {
                die('registration does not have navigation property with name: ' . $navigationPropName);
            }
            break;
                    
        case ($srcClass == 'song'):
            if ($navigationPropName == 'album') {
                $query = "SELECT * FROM album"
						 ." WHERE song = ".$namedKeyValues['id'][0];
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                        
                $result = $this->_serializeAlbums($stmt);
            } else if ($navigationPropName == 'artist') {
                $query = "SELECT * FROM artist"
						 ."WHERE song = ".$namedKeyValues['id'][0];
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                        
                $result = $this->_serializeArtists($stmt);
            }
			else {
                die('song does not have navigation property with name: ' . $navigationPropName);
            }
            break;
                 
        case ($srcClass == 'album'):
			if ($navigationPropName == 'song') {
                $query = "SELECT * FROM song "
                        ." WHERE album = ".$namedKeyValues['id'][0];
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                            
                $result = $this->_serializeSongs($stmt);
            } else {
				die('album does not have navigation property with name: ' . $navigationPropName);
			}
            break;
                    
        case ($srcClass == 'artist'):
            if ($navigationPropName == 'song') {
                $query = "SELECT * FROM song "
                        ." AND artist = ".$namedKeyValues['id'][0];
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                            
                $result = $this->_serializeSongs($stmt);
            }  else {
                die('artist does not have navigation property with name: ' . $navigationPropName);
            }
            break;
        }
        
        mysql_free_result($stmt);
        return empty($result) ? null : $result[0];
    }
    /**
     * Get related resource for a resource
     * 
     * @param ResourceSet      $sourceResourceSet    The source resource set
     * @param mixed            $sourceEntityInstance The source resource
     * @param ResourceSet      $targetResourceSet    The resource set of 
     *                                               the navigation property
     * @param ResourceProperty $targetProperty       The navigation property to be 
     *                                               retrieved
     * 
     * @return Object/null The related resource if exists else null
     */
    public function getRelatedResourceReference(ResourceSet $sourceResourceSet, 
        $sourceEntityInstance, 
        ResourceSet $targetResourceSet,
        ResourceProperty $targetProperty
    ) {
        $result = null;
        $srcClass = get_class($sourceEntityInstance);
        $navigationPropName = $targetProperty->getName();
        
        switch (true) {
        case ($srcClass == 'user'):
            if ($navigationPropName == 'registration') {
                $query = "SELECT * FROM registration WHERE user = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                $stmt = mysql_query($query);
                $data = mysql_fetch_assoc($stmt);
                $result = $this->_serializeRegistration($data);
                if ( $stmt === false) {            
                    die(mysql_error());
                }
                        
                if (!mysql_num_rows($stmt)) {
                    $result =  null;
                }
            } else if ($navigationPropName == 'favourites') {
                $query = "SELECT * FROM favourites WHERE user = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                $stmt = mysql_query($query);
                $data = mysql_fetch_assoc($stmt);
                $result = $this->_serializeFavourite($data);
                if ( $stmt === false) {            
                    die(mysql_error());
                }
                        
                if (!mysql_num_rows($stmt)) {
                    $result =  null;
                }
            } else if ($navigationPropName == 'recentlyplayed') {
                $query = "SELECT * FROM recentlyplayed WHERE user = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                $stmt = mysql_query($query);
                $data = mysql_fetch_assoc($stmt);
                $result = $this->_serializeRecentP($data);
                if ( $stmt === false) {            
                    die(mysql_error());
                }
                        
                if (!mysql_num_rows($stmt)) {
                    $result =  null;
                }
            } else {
                die('user does not have navigation property with name: ' . $navigationPropName);
            }
            break;

        case ($srcClass == 'registration'):
            if ($navigationPropName == 'user') {
                //$query = "SELECT * FROM user WHERE registration = $sourceEntityInstance->id";
				$query = "SELECT u.* FROM user u"
						." INNER JOIN registration r on r.user = u.id "
						." AND r.id = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                        
                if (!mysql_num_rows($stmt)) {
                    $result =  null;
                }
                        
                $data = mysql_fetch_assoc($stmt);
                $result = $this->_serializeUser($data);
                      
            } else {
                die('registration does not have navigation property with name: ' . $navigationPropName);
            }
            break;
			
		case ($srcClass == 'song'):
            if ($navigationPropName == 'album') {
				$query = "SELECT a.* FROM album a"
						." INNER JOIN song s on s.album = a.id "
						." AND s.id = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                        
                if (!mysql_num_rows($stmt)) {
                    $result =  null;
                }
                        
                $data = mysql_fetch_assoc($stmt);
                $result = $this->_serializeAlbum($data);
                      
            } else if ($navigationPropName == 'artist') {
				$query = "SELECT a.* FROM artist a"
						." INNER JOIN song s on s.artist = a.id "
						." AND s.id = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                        
                if (!mysql_num_rows($stmt)) {
                    $result =  null;
                }
                        
                $data = mysql_fetch_assoc($stmt);
                $result = $this->_serializeArtist($data);
                      
            }
			else {
                die('song does not have navigation property with name: ' . $navigationPropName);
            }
            break;
        case ($srcClass == 'album'):
			if ($navigationPropName == 'song') {
                $query = "SELECT * FROM song "
                        ." WHERE album = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                            
                $result = $this->_serializeSongs($stmt);
            } else {
				die('album does not have navigation property with name: ' . $navigationPropName);
			}
            break;
                    
        case ($srcClass == 'artist'):
            if ($navigationPropName == 'song') {
                $query = "SELECT * FROM song "
                        ." AND artist = $sourceEntityInstance->id";
                $stmt = mysql_query($query);
                if ( $stmt === false) {
                    die(mysql_error());
                }
                            
                $result = $this->_serializeSongs($stmt);
            }  else {
                die('artist does not have navigation property with name: ' . $navigationPropName);
            }
            break;
		}
        
        mysql_free_result($stmt);
        return $result;
    }	  
    
    /**
     * Serialize the mysql result array into User objects
     * 
     * @param array(array) $result result of the mysql query
     * 
     * @return array(Object)
     */
    private function _serializeUsers($result)
    {
        $users = array();
        while ($record = mysql_fetch_array($result, MYSQL_ASSOC)) {
             $users[] = $this->_serializeUser($record);
        }

        return $users;
    }

    /**
     * Serialize the mysql row into User object
     * 
     * @param array $record each User row
     * 
     * @return Object
     */
    private function _serializeUser($record)
    {
        $user = new user();
        $user->id = $record['id'];
        $user->fname = $record['fname'];
		$user->lname = $record['lname'];
		$user->gender = $record['gender'];
		$user->email = $record['email'];
		$user->phone = $record['phone'];
        
        return $user;
    }
    
    /**
     * Serialize the mysql result array into Registration objects
     * 
     * @param array(array) $result result of the mysql query
     * 
     * @return array(Object)
     */
    private function _serializeRegistrations($result)
    {
        $registrations = array();
        while ($record = mysql_fetch_array($result, MYSQL_ASSOC)) {         
             $registrations[] = $this->_serializeRegistration($record);
        }

        return $registrations;
    }

    /**
     * Serialize the mysql row into Registration object
     * 
     * @param array $record each registration row
     * 
     * @return Object
     */
    private function _serializeRegistration($record)
    {
        $registration = new registration();
        $registration->user = $record['user'];
        $registration->username = $record['username'];
        $registration->password = $record['password'];
        $registration->securityques = $record['securityques'];
		$registration->answer = $record['answer'];
		$registration->approved = $record['approved'];
		$registration->id = $record['id'];
        return $registration;
    }
	
	/**
     * Serialize the mysql result array into Album objects
     * 
     * @param array(array) $result result of the mysql query
     * 
     * @return array(Object)
     */
    private function _serializeAlbums($result)
    {
        $albums = array();
        while ($record = mysql_fetch_array($result, MYSQL_ASSOC)) {
             $albums[] = $this->_serializeAlbum($record);
        }

        return $albums;
    }

    /**
     * Serialize the mysql row into Album object
     * 
     * @param array $record each Album row
     * 
     * @return Object
     */
    private function _serializeAlbum($record)
    {
        $album = new album();
        $album->id = $record['id'];
        $album->name = $record['name'];
        
        return $album;
    }
	
	/**
     * Serialize the mysql result array into Artist objects
     * 
     * @param array(array) $result result of the mysql query
     * 
     * @return array(Object)
     */
    private function _serializeArtists($result)
    {
        $artists = array();
        while ($record = mysql_fetch_array($result, MYSQL_ASSOC)) {
             $artists[] = $this->_serializeArtist($record);
        }

        return $artists;
    }

    /**
     * Serialize the mysql row into Artist object
     * 
     * @param array $record each Artist row
     * 
     * @return Object
     */
    private function _serializeArtist($record)
    {
        $artist = new artist();
        $artist->id = $record['id'];
        $artist->name = $record['name'];
        
        return $artist;
    }
	
	/**
     * Serialize the mysql result array into Song objects
     * 
     * @param array(array) $result result of the mysql query
     * 
     * @return array(Object)
     */
    private function _serializeSongs($result)
    {
        $songs = array();
        while ($record = mysql_fetch_array($result, MYSQL_ASSOC)) {
             $songs[] = $this->_serializeSong($record);
        }

        return $songs;
    }

    /**
     * Serialize the mysql row into Song object
     * 
     * @param array $record each Song row
     * 
     * @return Object
     */
    private function _serializeSong($record)
    {
        $song = new song();
        $song->id = $record['id'];
        $song->title = $record['title'];
		$song->album = $record['album'];
		$song->genre = $record['genre'];
		$song->artist = $record['artist'];
		$song->location = $record['location'];
		$song->category = $record['category'];
        
        return $song;
    }
	
	/**
     * Serialize the mysql result array into Rating objects
     * 
     * @param array(array) $result result of the mysql query
     * 
     * @return array(Object)
     */
    private function _serializeRatings($result)
    {
        $ratings = array();
        while ($record = mysql_fetch_array($result, MYSQL_ASSOC)) {
             $ratings[] = $this->_serializeRating($record);
        }

        return $ratings;
    }

    /**
     * Serialize the mysql row into Rating object
     * 
     * @param array $record each Rating row
     * 
     * @return Object
     */
    private function _serializeRating($record)
    {
        $rating = new rating();
		$rating->id = $record['id'];
        $rating->user = $record['user'];
        $rating->song = $record['song'];
		$rating->stars = $record['stars'];
		
        return $rating;
    }
	
	/**
     * Serialize the mysql result array into Favourite objects
     * 
     * @param array(array) $result result of the mysql query
     * 
     * @return array(Object)
     */
    private function _serializeFavourites($result)
    {
        $favourites = array();
        while ($record = mysql_fetch_array($result, MYSQL_ASSOC)) {
             $favourites[] = $this->_serializeFavourite($record);
        }

        return $favourites;
    }

    /**
     * Serialize the mysql row into Favourite object
     * 
     * @param array $record each Favourite row
     * 
     * @return Object
     */
    private function _serializeFavourite($record)
    {
        $favourite = new favourites();
		$favourite->id = $record['id'];
        $favourite->user = $record['user'];
        $favourite->song = $record['song'];
		
        return $favourite;
    }
	
	
	/**
     * Serialize the mysql result array into RecentlyPlayed objects
     * 
     * @param array(array) $result result of the mysql query
     * 
     * @return array(Object)
     */
    private function _serializeRecentlyPlayed($result)
    {
        $recentlyplayed = array();
        while ($record = mysql_fetch_array($result, MYSQL_ASSOC)) {
             $recentlyplayed[] = $this->_serializeRecentP($record);
        }

        return $recentlyplayed;
    }

    /**
     * Serialize the mysql row into Favourite object
     * 
     * @param array $record each Favourite row
     * 
     * @return Object
     */
    private function _serializeRecentP($record)
    {
        $recentP = new recentlyplayed();
		$recentP->id = $record['id'];
        $recentP->user = $record['user'];
        $recentP->song = $record['song'];
		if (!is_null($record['playeddate'])) {
            $dateTime = new DateTime($record['playeddate']);
        } else {
            $recentP->Date = null;
        }
		
        return $recentP;
    }
	
	
    
   
}
?>