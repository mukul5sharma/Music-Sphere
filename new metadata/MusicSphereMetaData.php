<?php
/** 
 * Implementation of IDataServiceMetadataProvider.
 * 
 * PHP version 5.3
 * 
 * @category  Service
 * @package   MusicSphere
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
use ODataProducer\Providers\Metadata\ResourceStreamInfo;
use ODataProducer\Providers\Metadata\ResourceAssociationSetEnd;
use ODataProducer\Providers\Metadata\ResourceAssociationSet;
use ODataProducer\Common\NotImplementedException;
use ODataProducer\Providers\Metadata\Type\EdmPrimitiveType;
use ODataProducer\Providers\Metadata\ResourceSet;
use ODataProducer\Providers\Metadata\ResourcePropertyKind;
use ODataProducer\Providers\Metadata\ResourceProperty;
use ODataProducer\Providers\Metadata\ResourceTypeKind;
use ODataProducer\Providers\Metadata\ResourceType;
use ODataProducer\Common\InvalidOperationException;
use ODataProducer\Providers\Metadata\IDataServiceMetadataProvider;
require_once 'ODataProducer\Providers\Metadata\IDataServiceMetadataProvider.php';
use ODataProducer\Providers\Metadata\ServiceBaseMetadata;

//Begin Resource Classes

/**
 * User entity type.
 * 
 * @category  Service
 * @package   MusicSphere
 * @author    Microsoft Open Technologies, Inc. <msopentech@microsoft.com>
 * @copyright Microsoft Open Technologies, Inc.
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   GIT: 1.2
 * @link      https://github.com/MSOpenTech/odataphpprod
 */
class user
{
    //Key Edm.Int32
    public $id;
    //Edm.String
    public $fname;
    //Edm.String
    public $lname;
    //Edm.String
    public $gender;
    //Edm.String
    public $email;
    //Edm.String
    public $phone;
	// Navigation Property registration (ResourceReference)
	public $registration;
	// Navigation Property favourites (ResourceSetReference)
	public $favourites;
	// Navigation Property recentlyplayed (ResourceSetReference)
	public $recentlyplayed;

}
/**
 * Album entity type.
 * 
 * @category  Service
 * @package   MusciSphere
 * @author    Microsoft Open Technologies, Inc. <msopentech@microsoft.com>
 * @copyright Microsoft Open Technologies, Inc.
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   GIT: 1.2
 * @link      https://github.com/MSOpenTech/odataphpprod
 */
class album
{
	// Key Edm.Int32
	public $id;
	// Edm.String
	public $name;
	// Navigation Property song (ResourceSetReference)
	public $song;
}

/**
 * Artist entity type.
 * 
 * @category  Service
 * @package   MusciSphere
 * @author    Microsoft Open Technologies, Inc. <msopentech@microsoft.com>
 * @copyright Microsoft Open Technologies, Inc.
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   GIT: 1.2
 * @link      https://github.com/MSOpenTech/odataphpprod
 */
class artist
{
	// Key Edm.Int32
	public $id;
	// Edm.String
	public $name;
	// Navigation Property song (ResourceSetReference)
	public $song;
}

/**
 * Registration entity type.
 * 
 * @category  Service
 * @package   MusicSphere
 * @author    Microsoft Open Technologies, Inc. <msopentech@microsoft.com>
 * @copyright Microsoft Open Technologies, Inc.
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   GIT: 1.2
 * @link      https://github.com/MSOpenTech/odataphpprod
 */
class registration
{
	// Key Edm.Int32
	public $id;
	// Navigation Property User (ResourceReference)
	public $user;
	// Edm.String
	public $username;
	// Edm.String
	public $password;
	// Edm.String
	public $securityques;
	// Edm.String
	public $answer;
	// Edm.Boolean
	public $approved;
}

/**
 * Song entity type.
 * 
 * @category  Service
 * @package   MusicSphere
 * @author    Microsoft Open Technologies, Inc. <msopentech@microsoft.com>
 * @copyright Microsoft Open Technologies, Inc.
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   GIT: 1.2
 * @link      https://github.com/MSOpenTech/odataphpprod
 */
class song
{
	// key Edm.Int32
	public $id;
	// Edm.String
	public $title;
	// Edm.Int32
	public $album;
	// Edm.String
	public $genre;
	// Edm.Int32
	public $artist;
	// Edm.String
	public $location;
	// Edm.String
	public $category;
}

/**
 * Rating entity type.
 * 
 * @category  Service
 * @package   MusicSphere
 * @author    Microsoft Open Technologies, Inc. <msopentech@microsoft.com>
 * @copyright Microsoft Open Technologies, Inc.
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   GIT: 1.2
 * @link      https://github.com/MSOpenTech/odataphpprod
 */
class rating
{
	// key Edm.Int32
	public $id;
	// Edm.Int32
	public $song;
	// Edm.Int32
	public $user;
	// Edm.Double
	public $stars;
}

/**
 * RecentlyPlayed entity type.
 * 
 * @category  Service
 * @package   MusicSphere
 * @author    Microsoft Open Technologies, Inc. <msopentech@microsoft.com>
 * @copyright Microsoft Open Technologies, Inc.
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   GIT: 1.2
 * @link      https://github.com/MSOpenTech/odataphpprod
 */
class recentlyplayed
{
	// key Edm.Int32
	public $id;
	// key Edm.Int32
	public $user;
	// Edm.Int32
	public $song;
	// Edm.DateTime
	public $playeddate;
}

/**
 * Favourites entity type.
 * 
 * @category  Service
 * @package   MusicSphere
 * @author    Microsoft Open Technologies, Inc. <msopentech@microsoft.com>
 * @copyright Microsoft Open Technologies, Inc.
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   GIT: 1.2
 * @link      https://github.com/MSOpenTech/odataphpprod
 */
class favourites
{
	// key Edm.Int32
	public $id;
	// Edm.Int32
	public $song;
	// Edm.Int32
	public $user;
}

/**
 * Create MusicSphere metadata.
 * 
 * @category  Service
 * @package   MusicSphere
 * @author    Microsoft Open Technologies, Inc. <msopentech@microsoft.com>
 * @copyright Microsoft Open Technologies, Inc.
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   GIT: 1.2
 * @link      https://github.com/MSOpenTech/odataphpprod
 */
class CreateMusicSphereMetadata
{
    /**
     * create metadata
     * 
     * @throws InvalidOperationException
     * 
     * @return MusicSphereMetadata
     */
    public static function create()
    {
        $metadata = new ServiceBaseMetadata('MusicSphereEntities', 'MusicSphere');
    
        //Register the entity (resource) type 'User'
        $userEntityType = $metadata->addEntityType(new ReflectionClass('user'), 'user', 'MusicSphere');
        $metadata->addKeyProperty($userEntityType, 'id', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($userEntityType, 'fname', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($userEntityType, 'lname', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($userEntityType, 'gender', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($userEntityType, 'email', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($userEntityType, 'phone', EdmPrimitiveType::STRING);
        
    
        //Register the entity (resource) type 'Registration'
        $registrationEntityType = $metadata->addEntityType(new ReflectionClass('registration'), 'registration', 'MusicSphere');
        $metadata->addKeyProperty($registrationEntityType, 'id', EdmPrimitiveType::INT32);
		$metadata->addPrimitiveProperty($registrationEntityType, 'username', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($registrationEntityType, 'password', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($registrationEntityType, 'securityques', EdmPrimitiveType::STRING);
		$metadata->addPrimitiveProperty($registrationEntityType, 'answer', EdmPrimitiveType::STRING);
		$metadata->addPrimitiveProperty($registrationEntityType, 'approved', EdmPrimitiveType::BOOLEAN);
    
        //Register the entity (resource) type 'Song'
        $songsEntityType = $metadata->addEntityType(new ReflectionClass('song'), 'song', 'MusicSphere');
        $metadata->addKeyProperty($songsEntityType, 'id', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($songsEntityType, 'title', EdmPrimitiveType::STRING);
        $metadata->addPrimitiveProperty($songsEntityType, 'genre', EdmPrimitiveType::STRING);
		$metadata->addPrimitiveProperty($songsEntityType, 'location', EdmPrimitiveType::STRING);
		$metadata->addPrimitiveProperty($songsEntityType, 'category', EdmPrimitiveType::STRING);
    
        //Register the entity (resource) type 'Album'
        $albumEntityType = $metadata->addEntityType(new ReflectionClass('album'), 'album', 'MusicSphere');
        $metadata->addKeyProperty($albumEntityType, 'id', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($albumEntityType, 'name', EdmPrimitiveType::STRING);
    
        //Register the entity (resource) type 'Artist'
        $artistEntityType = $metadata->addEntityType(new ReflectionClass('artist'), 'artist', 'MusicSphere');
        $metadata->addKeyProperty($artistEntityType, 'id', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($artistEntityType, 'name', EdmPrimitiveType::STRING);
		
		//Register the entity (resource) type 'Rating'
        $ratingEntityType = $metadata->addEntityType(new ReflectionClass('rating'), 'rating', 'MusicSphere');
        $metadata->addKeyProperty($ratingEntityType, 'id', EdmPrimitiveType::INT32);
		$metadata->addPrimitiveProperty($ratingEntityType, 'stars', EdmPrimitiveType::DOUBLE);
		
		//Register the entity (resource) type 'Favourites'
        $favouritesEntityType = $metadata->addEntityType(new ReflectionClass('favourites'), 'favourites', 'MusicSphere');
		$metadata->addKeyProperty($favouritesEntityType, 'id', EdmPrimitiveType::INT32);
		
		//Register the entity (resource) type 'RecentlyPlayed'
        $recentlyplayedEntityType = $metadata->addEntityType(new ReflectionClass('recentlyplayed'), 'recentlyplayed', 'MusicSphere');
		$metadata->addKeyProperty($recentlyplayedEntityType, 'id', EdmPrimitiveType::INT32);
        $metadata->addPrimitiveProperty($recentlyplayedEntityType, 'playeddate', EdmPrimitiveType::DATETIME);
    
	
        $userResourceSet = $metadata->addResourceSet('user', $userEntityType);
        $registrationResourceSet = $metadata->addResourceSet('registration', $registrationEntityType);
        $songsResourceSet = $metadata->addResourceSet('song', $songsEntityType);
        $albumsResourceSet = $metadata->addResourceSet('album', $albumEntityType);
        $artistResourceSet = $metadata->addResourceSet('artist', $artistEntityType);
		$ratingResourceSet = $metadata->addResourceSet('rating', $ratingEntityType);
		$favouritesResourceSet = $metadata->addResourceSet('favourites', $favouritesEntityType);
		$recentlyplayedResourceSet = $metadata->addResourceSet('recentlyplayed', $recentlyplayedEntityType);
        
        // associations of Users
		$metadata->addResourceReferenceProperty($userEntityType, 'registration', $registrationResourceSet);
		$metadata->addResourceSetReferenceProperty($userEntityType, 'favourites', $favouritesResourceSet);
		$metadata->addResourceSetReferenceProperty($userEntityType, 'recentlyplayed', $recentlyplayedResourceSet);
		
		//associations of Registration
        $metadata->addResourceReferenceProperty($registrationEntityType, 'user', $userResourceSet);
		
        //associations of Songs
        $metadata->addResourceSetReferenceProperty($songsEntityType, 'album', $albumsResourceSet);
        $metadata->addResourceSetReferenceProperty($songsEntityType, 'artist', $artistResourceSet);
        
		// associations of Album
		$metadata->addResourceSetReferenceProperty($albumEntityType, 'song', $songsResourceSet);
		
		// associations of Artist
		$metadata->addResourceSetReferenceProperty($artistEntityType, 'song', $songsResourceSet);
		
		//associations of Favourites
        $metadata->addResourceSetReferenceProperty($favouritesEntityType, 'song', $songsResourceSet);
		$metadata->addResourceSetReferenceProperty($favouritesEntityType, 'user', $userResourceSet);
		
        //associations of Ratings
        $metadata->addResourceSetReferenceProperty($ratingEntityType, 'song', $songsResourceSet);
		$metadata->addResourceSetReferenceProperty($ratingEntityType, 'user', $userResourceSet);
		
		//associations of RecentlyPlayed
        $metadata->addResourceSetReferenceProperty($recentlyplayedEntityType, 'song', $songsResourceSet);
		$metadata->addResourceSetReferenceProperty($recentlyplayedEntityType, 'user', $userResourceSet);
    
        return $metadata;
    }
}
?>
