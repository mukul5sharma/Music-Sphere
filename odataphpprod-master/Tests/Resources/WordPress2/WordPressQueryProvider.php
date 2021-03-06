<?php
/** 
 * Implementation of IDataServiceQueryProvider.
 * 
 * PHP version 5.3
 * 
 * @category  Service
 * @package   WordPress
 * @author    Bibin Kurian <odataphpproducer_alias@microsoft.com>
 * @copyright 2011 Microsoft Corp. (http://www.microsoft.com)
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   SVN: 1.0
 * @link      http://odataphpproducer.codeplex.com
 * 
 */
use ODataProducer\UriProcessor\ResourcePathProcessor\SegmentParser\KeyDescriptor;
use ODataProducer\Providers\Metadata\ResourceSet;
use ODataProducer\Providers\Metadata\ResourceProperty;
use ODataProducer\Providers\Query\IDataServiceQueryProvider2;
use ODataProducer\Common\ODataException;
require_once "WordPressMetadata.php";
require_once "ODataProducer\Providers\Query\IDataServiceQueryProvider2.php";

/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

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
 * @package   WordPress
 * @author    Bibin Kurian <odataphpproducer_alias@microsoft.com>
 * @copyright 2011 Microsoft Corp. (http://www.microsoft.com)
 * @license   New BSD license, (http://www.opensource.org/licenses/bsd-license.php)
 * @version   Release: 1.0
 * @link      http://odataphpproducer.codeplex.com
 */
class WordPressQueryProvider implements IDataServiceQueryProvider2
{
	/**
	 * The not implemented error message
	 * @var string
	 */
	private $_message = 'This functionality is nnot implemented as the class is only for testing IExpressionProvider for MySQL';

    /**
     * Reference to the custom expression provider
     *
     * @var NorthWindDSExpressionProvider
     */
    private $_wordPressMySQLExpressionProvider;
    
    /**
     * Constructs a new instance of WordPressQueryProvider
     * 
     */
    public function __construct()
    {
    }
    
    /**
     * (non-PHPdoc)
     * @see ODataProducer\Providers\Query.IDataServiceQueryProvider2::getExpressionProvider()
     */
    public function getExpressionProvider()
    {
    	if (is_null($this->_wordPressMySQLExpressionProvider)) {
    		$this->_wordPressMySQLExpressionProvider = new WordPressDSExpressionProvider();
    	}
    	
    	return $this->_wordPressMySQLExpressionProvider;
    }
    
    /**
     * Gets collection of entities belongs to an entity set
     * 
     * @param ResourceSet      $resourceSet   The entity set whose 
     *                                        entities needs to be fetched
     * @param string           $filterOption  Contains the filter condition
     * @param string           $select        For future purpose,no need to pass it
     * @param string           $orderby       For future purpose,no need to pass it
     * @param string           $top           For future purpose,no need to pass it
     * @param string           $skip          For future purpose,no need to pass it
     * 
     * @return array(Object)
     */
    public function getResourceSet(ResourceSet $resourceSet,$filter=null,$select=null,$orderby=null,$top=null,$skip=null)
    {
    	ODataException::createNotImplementedError($this->_message);
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
    	ODataException::createNotImplementedError($this->_message);
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
     * @param string           $filterOption         Contains the filter condition
     * @param string           $select               For future purpose,no need to pass it
     * @param string           $orderby              For future purpose,no need to pass it
     * @param string           $top                  For future purpose,no need to pass it
     * @param string           $skip                 For future purpose,no need to pass it
     *                                               
     * @return array(Objects)/array() Array of related resource if exists, if no 
     *                                related resources found returns empty array
     */
    public function  getRelatedResourceSet(ResourceSet $sourceResourceSet, 
        $sourceEntityInstance, 
        ResourceSet $targetResourceSet,
        ResourceProperty $targetProperty,
        $filter=null ,$select=null, $orderby=null, $top=null, $skip=null
    ) {
    	ODataException::createNotImplementedError($this->_message);
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
    	ODataException::createNotImplementedError($this->_message);
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
    	ODataException::createNotImplementedError($this->_message);
    }
}
?>