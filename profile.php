<?php
/**
 * profile.php
 *
 * @author Nicolas CARPi <nicolas.carpi@curie.fr>
 * @copyright 2012 Nicolas CARPi
 * @see https://www.elabftw.net Official website
 * @license AGPL-3.0
 * @package elabftw
 */
namespace Elabftw\Elabftw;

use Exception;

/**
 * Display profile of current user
 *
 */
require_once 'app/init.inc.php';
$App->pageTitle = _('Profile');

try {
    // get total number of experiments
    $Entity = new Experiments($Users);
    $Entity->setUseridFilter();
    $itemsArr = $Entity->read();
    $count = count($itemsArr);

    $UserStats = new UserStats($Users, $count);
    $TagCloud = new TagCloud($Users->userid);

    $template = 'profile.html';
    $renderArr = array(
        'Users' => $Users,
        'UserStats' => $UserStats,
        'TagCloud' => $TagCloud,
        'count' => $count
    );

} catch (Exception $e) {
    $App->Logs->create('Error', $Session->get('userid'), $e->getMessage());
    $template = 'error.html';
    $renderArr = array('error' => $e->getMessage());
}

$renderArr = array_merge($baseRenderArr, $renderArr);
echo $Twig->render($template, $renderArr);
