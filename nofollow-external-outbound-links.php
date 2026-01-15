<?php
/*
Plugin Name: Adding Nofollow External/Outbound Link
Description: Adding rel="nofollow" attribute to external/outbound links which will be added advantages for your SEO Score.
Version: 1.0.0
Author: Sumit Malviya
Author URI: https://www.webfriendy.com/
Donate link: https://www.webfriendy.com/contact-us/
Tags: SEO, Type attribute warning removal", rel="nofollow", Noindex, Outbound links, External URL's.
Requires at least: 5.0
Tested up to: 6.4
Requires PHP: 7.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
*/

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Nofollow_outbound_Links' ) ) {
    class Nofollow_outbound_Links {

        public function __construct() {
            add_filter('the_content', array($this, 'nofollow_external_link'));
            add_filter('the_excerpt', array($this, 'nofollow_external_link'));
            add_filter('widget_text_content', array($this, 'nofollow_external_link'));
        }

        function nofollow_external_link($content) {    
            return preg_replace_callback('/<a[^>]+/', array($this, 'nofollow_external_link_call'), $content);    
        }
 
        function nofollow_external_link_call($link) {
            
            $nofollolink = $link[0];
            $home_url = home_url();
        
            if (strpos($nofollolink, 'rel') === false) {
                $nofollolink = preg_replace("%(href=\S(?!$home_url))%i", 'rel="nofollow" $1', $nofollolink);
            } elseif (preg_match("%href=\S(?!$home_url)%i", $nofollolink)) {
                $nofollolink = preg_replace('/rel=\S(?!nofollow)\S*/i', 'rel="nofollow"', $nofollolink);
            }
            
            return $nofollolink;
        
        }
    }
}

$Nofollow_oubound = new Nofollow_outbound_Links();