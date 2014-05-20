<?php
/**
 * Initialises CWP-specific configuration settings, to avoid _config.php.
 */
class CwpInitialisationFilter implements RequestFilter {

	/**
	 * @var Enable egress proxy. This works on the principle of setting environment variables,
	 *	which will be automatically picked up by curl. This means RestfulService and raw curl
	 *	requests should work out of the box. Stream-based requests need extra manual configuration.
	 *	Refer to https://www.cwp.govt.nz/guides/core-technical-documentation/common-web-platform-core/en/how-tos/external_http_requests_with_proxy
	 */
	private static $egress_proxy_default_enabled = true;

	public function preRequest(SS_HTTPRequest $request, Session $session, DataModel $model) {

		if (Config::inst()->get('CwpInitialisationFilter', 'egress_proxy_default_enabled')) {

			if(defined('SS_OUTBOUND_PROXY') && defined('SS_OUTBOUND_PROXY_PORT')) {
				putenv('http_proxy=' . SS_OUTBOUND_PROXY . ':' . SS_OUTBOUND_PROXY_PORT);
				putenv('https_proxy=' . SS_OUTBOUND_PROXY . ':' . SS_OUTBOUND_PROXY_PORT);
			}

		}

		return true;
	}

	public function postRequest(SS_HTTPRequest $request, SS_HTTPResponse $response, DataModel $model) {
		return true;
	}

}

