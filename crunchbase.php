<?php

/**
 * PHP Crunchbase API Library
 * 
 * For more information refer to https://developer.crunchbase.com/docs
 * @author Juancho Rossi <juancho@juanchorossi.com>
 */
class CrunchBase
{
	protected $base_url = 'http://api.crunchbase.com/v/2/';

	// ==============================================================

	public function __construct($user_key, $format = 'json')
	{
		$this->user_key = $user_key;
		$this->format 	= $format;
	}
    
	// ==============================================================

	/**
	 * Organization
	 *
	 * This operation returns the properties and relationships of the Organization for the given permalink.
	 *
	 * @param string $permalink The permalink of the requested Organization
	 * @return string JSON
	 */
    public function organization($permalink)
    {
    	$_query = array('permalink' => $permalink);

        return $this->curl_execute($method = 'organization', $_query);
    }	

    // ==============================================================

	/**
	 * Organizations
	 *
	 * Returns a paginated collection of all active Organizations in CrunchBase.
	 *
	 * @param array[string] $query Text search of Organizations (name, previous names, location, and domain name). 
	 * When a developer passes this search parameter, the system implicitly applies typo 
	 * correction to the passed value. Returned results are ordered algorithmically
	 * @param array[string] $name Text search of Organizations by name. When a developer passes this search parameter, 
	 * the system implicitly applies typo correction to the passed value. Returned results are ordered algorithmically.
	 * @param array[string] $domain_name Search Organizations by full or partial domain name. When a developer passes 
	 * this search parameter, the system <em>will not<em> apply typo correction and will attempt to match on the exact string.
	 * If the developer passes a hostname that starts with 'www', the system will also try to match on the domain name 
	 * Returned results are ordered algorithmically.
	 * @param array[string] $organization_types Filter Organizations by one or more types. Multiple types should be separated 
	 * by commas. When a developer passes multiple organization_types, the system connects them with an implicit OR. 
	 * The 'order' parameter is ignored when using the 'organization_types' parameter, as the results are ordered algorithmically.
	 * (company|investor|school|group)
	 * @param array[string] $location_uuids Filter Organizations by one or more Location UUIDs. Multiple Location UUIDs should be 
	 * separated by commas. When a developer passes multiple Location UUIDs, the system connects them with an implicit OR. 
	 * The 'order' parameter is ignored when using the 'location_uuids' parameter, as the results are ordered algorithmically.	 
	 * @param array[string] $category_uuids Filter Organizations by one or more Category UUIDs. Multiple Category UUIDs should be 
	 * separated by commas (','). When a developer passes multiple Category UUIDs, the system connects them with an implicit OR. 
	 * The 'order' parameter is ignored when using the 'category_uuids' parameter, as the results are ordered algorithmically.
	 * @return string JSON
	 */
    public function organizations($params)
    {
    	extract($params);

    	$_query = array('query'					=> ! empty($query) 					? $query 						: NULL,
    					'name'					=> ! empty($name) 					? $name 						: NULL,
    					'domain_name'			=> ! empty($domain_name) 			? $domain_name 					: NULL,
    					'organization_types'	=> isset($organization_types) 		? (is_array($organization_types) 	? implode(',', $organization_types) : $organization_types) 	: NULL,
    					'location_uuids'		=> isset($location_uuids) 			? (is_array($location_uuids) 		? implode(',', $location_uuids) 	: $location_uuids) 		: NULL,
    					'category_uuids'		=> isset($category_uuids) 			? (is_array($category_uuids) 		? implode(',', $category_uuids) 	: $category_uuids) 		: NULL,
    					'page'					=> ! empty($page) 					? $page 						: 1,
    					);

    	// FIX for inconsistent API declaration
    	$this->order_by 	= isset($order_by) && in_array($order_by, array('created_at', 'created_at', 'updated_at', 'updated_at')) ? $order_by : 'updated_at';
    	$this->sort_order 	= isset($sort_order) && in_array($sort_order, array('ASC', 'DESC')) ? $sort_order : 'ASC';

        return $this->curl_execute($method = 'organizations', $_query);
    }

	// ==============================================================

	/**
     * People
     *
     * This operation returns a paginated list of all People in CrunchBase.
     *
     * @param array[string] $page The page of results to retrieve
     * @return string JSON
     */
    public function people($params)
    {
    	$_query = array('page' => isset($params['page']) ? $params['page'] : 1);

        return $this->curl_execute($method = 'people', $_query);
    }

    // ==============================================================

    /**
     * Person
     *
     * This operation returns the properties and relationships of the Person for the given permalink.
     *
     * @param string $permalink The permalink of the requested Person
     * @return string JSON
     */
    public function person($permalink)
    {
    	$_query = array('permalink' => $permalink);

        return $this->curl_execute($method = 'person', $_query);
    }

	// ==============================================================

    /**
     * Product
     *
     * This operation returns the properties and relationships of the Product for the given permalink.
     *
     * @param string $permalink The permalink of the requested Product
     * @return string JSON
     */
    public function product($permalink)
    {
    	$_query = array('permalink' => $permalink);

        return $this->curl_execute($method = 'product', $_query);
    }

    // ==============================================================

	/**
     * Products
     *
     * This operation returns a paginated list of all Products in CrunchBase.
     *
     * @param string $permalink The permalink of the requested Product
     * @return string JSON
     */
    public function products($params)
    {
    	$_query = array('page' => isset($params['page']) ? $params['page'] : 1);

        return $this->curl_execute($method = 'products', $_query);
    }

	// ==============================================================

    /**
     * FundingRound
     *
     * This operation returns the properties and relationships of the Funding Round for the given uuid.
     *
     * @param string $uuid The uuid of the requested Funding Round
     * @return string JSON
     */
    public function funding_round($uuid)
    {
    	$_query = array('uuid' => $uuid);

        return $this->curl_execute($method = 'funding-round', $_query);
    }

	// ==============================================================

    /**
     * Acquisition
     *
     * This operation returns the properties and relationships of the Acquisition for the given uuid.
     *
     * @param string $uuid The uuid of the requested Acquisition
     * @return string JSON
     */
    public function acquisition($uuid)
    {
    	$_query = array('uuid' => $uuid);

        return $this->curl_execute($method = 'acquisition', $_query);
    }	

    // ==============================================================

    /**
     * FundRaise
     *
     * This operation returns the properties and relationships of the Fund Raise for the given uuid.
     *
     * @param string $uuid The uuid of the requested Fund Raise
     * @return string JSON
     */
    public function fund_raise($uuid)
    {
    	$_query = array('uuid' => $uuid);

        return $this->curl_execute($method = 'fund-raise', $_query);
    }

    // ==============================================================

    /**
     * IPO
     *
     * This operation returns the properties and relationships of the IPO for the given uuid.
     *
     * @param string $uuid The uuid of the requested IPO
     * @return string JSON
     */
    public function ipo($uuid)
    {
    	$_query = array('uuid' => $uuid);

        return $this->curl_execute($method = 'ipo', $_query);
    }

    // ==============================================================

	/**
     * Locations
     *
     * This operation returns a paginated list of all active Locations in CrunchBase.
     *
     * @param array[string] $page The page of results to retrieve
     * @return string JSON
     */
    public function locations($params)
    {
    	$_query = array('page' => isset($params['page']) ? $params['page'] : 1);

        return $this->curl_execute($method = 'locations', $_query);
    }

    // ==============================================================

	/**
     * Categories
     *
     * This operation returns a paginated list of all active Categories in CrunchBase.
     *
     * @param array[string] $page The page of results to retrieve
     * @return string JSON
     */
    public function categories($params)
    {
    	$_query = array('page' => isset($params['page']) ? $params['page'] : 1);

        return $this->curl_execute($method = 'categories', $_query);
    }

	// ==============================================================

    /**
     * Execute the HTTP query
     *
     * @return string
     */
    public function curl_execute($method, $_query)
    {
    	$api_url = "{$this->base_url}{$method}?".http_build_query($_query)."&user_key={$this->user_key}";
        
		if (isset($this->order_by) && isset($this->sort_order))
		{
			$api_url .= "&order={$this->order_by}+$this->sort_order";

			// Unset parameters for further requests
			unset($this->order_by);
			unset($this->sort_order);
		}

		$ch = curl_init($api_url);
        curl_setopt_array($ch, array(	CURLOPT_RETURNTRANSFER	=> TRUE,
										CURLOPT_TIMEOUT 		=> 5));

        $response		= curl_exec($ch);
        $http_status 	= curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if ($http_status !== 200)
        {
            echo "HTTP call failed with error {$http_status}.";
        }
        elseif ($response === FALSE)
        {
        	echo "HTTP call failed empty response.";
        }
        
		return ($this->format === 'json') ? $response : json_decode($response, TRUE);
    }
}