<?php
/**
 * Admin menu
 *
 * @author		Dmitriy Belyaev <admin@cogear.ru>
 * @copyright		Copyright (c) 2011, Dmitriy Belyaev
 * @license		http://cogear.ru/license.html
 * @link		http://cogear.ru
 * @package		Core
 * @subpackage
 * @version		$Id$
 */
class Admin_Menu extends Menu_Auto{
    /**
     * Constructor
     */
    public function __construct() {
        parent::__construct('admin', 'Admin.menu',Url::gear('admin'));
        hook('menu.user',array($this,'mixWith'),NULL,'user','admin');
    }
    
}