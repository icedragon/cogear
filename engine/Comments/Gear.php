<?php

/**
 * Comments gear
 *
 * @author		Dmitriy Belyaev <admin@cogear.ru>
 * @copyright		Copyright (c) 2011, Dmitriy Belyaev
 * @license		http://cogear.ru/license.html
 * @link		http://cogear.ru
 * @package		Core
 * @subpackage          
 * @version		$Id$
 */
class Comments_Gear extends Gear {

    protected $name = 'Comments';
    protected $description = 'Allow users to post comment for pages';

    /**
     * Init
     */
    public function init() {
        parent::init();
        hook('form.page-createdit.init', array($this, 'extendPageForm'));
        hook('Pages.showPage.after', array($this, 'attachCommentsToPage'));
        hook('stack.Page.info', array($this, 'extendPageInfo'));
        allow_role(array('comments post'),100);
    }

    /**
     * Hook page createdit form
     * 
     * @param object $Form 
     */
    public function extendPageForm($Form) {
        $data['allow_comments'] = array(
            'type' => 'checkbox',
            'label' => t('Allow comments'),
            'value' => 1
        );
        $Form->elements->place($data, 'submit', Form::BEFORE);
    }

    public function extendPageInfo($Stack) {
        $Stack->object()->allow_comments && $Stack->comments = icon('comments') . ' ' . HTML::a($Stack->object()->getUrl() . '#comments', $Stack->object()->comments);
    }

    /**
     *
     * @param type $Page 
     */
    public function attachCommentsToPage($Page) {
        if ($Page->allow_comments) {
            $this->showComments($Page);
            $this->showForm($Page);
        }
    }

    /**
     * Show comment post form
     * 
     * @param object $Page 
     */
    public function showForm($Page) {
        if (access('comments post')) {
            $form = new Form(array(
                        'name' => 'addComment',
                        'elements' => array(
                            'info' => array(
                                'type' => 'div',
                                'value' => t('Leave comment ').' '.$this->user->getAvatarLinked().' '.$this->user->getLink().' ↓ ',
                            ),
                            'body' => array(
                                'type' => 'textarea',
                                'validators' => array('Required', array('Length', 5)),
                                'filters' => array(array('strip_tags', '<b><i><u>')),
                            ),
                            'submit' => array(
                                'type' => 'submit',
                                'label' => t('Post'),
                            ),
                        )
                    ));
            if ($result = $form->result()) {
                $comment = new Comments_Object();
                $comment->pid = $Page->id;
                $comment->aid = $this->user->id;
                $comment->created_date = time();
                $comment->body = $result->body;
                $comment->ip = $this->session->ip;
                if ($comment->save()) {
                    $Page->comments = $this->db->where('pid',$Page->id)->count('comments');
                    $Page->save();
                    flash_success(t('Your comment has been successfully posted!'));
                    redirect($Page->getUrl());
                }
            }
            $form->show();
        }
    }

    /**
     * Show comments under current page
     * 
     * @param object $Page
     */
    public function showComments($Page) {
        $comments = new Comments_Object();
        $this->db->where('pid', $Page->id);
        $this->db->order('id', 'ASC');
        $grid = new Grid('comments');
        $grid->adopt($comments->findAll());
        $grid->show();
    }

    /**
     * Default dispatcher
     * 
     * @param string $action
     * @param string $subaction 
     */
    public function index($action = '', $subaction = NULL) {
        
    }

    /**
     * Custom dispatcher
     * 
     * @param   string  $subaction
     */
    public function action_index($subaction = NULL) {
        
    }

}