<?php

require_once '../classes/cache.class.php';
require_once '../classes/api.class.php';

// Api
$api = new Api(true);
$api->token = 'hN8hI0fnsqA9WGarX2GJfIohDlGKR_v_Vl1GiwComSmCfuxHqTLfinbK-_f1lm4UG_9uBaNq-9y8MozGkTE=';

// Repositories
$repositories = array();

$repositorie_page = 0;
do
{
    $repositorie_page++;
    $bb_repositories = $api->call('https://api.bitbucket.org/2.0/repositories/uzik',array('page'=>$repositorie_page,'pagelen'=>'100'));

    // Each value
    foreach($bb_repositories->values as $_repositorie)
    {
        // Reformat and save
        $reformated_repositorie            = new stdClass();
        $reformated_repositorie->name      = $_repositorie->name;
        $reformated_repositorie->full_name = $_repositorie->full_name;
        $reformated_repositorie->commits   = array();

        // Commits
        $commits_page = 0;
        do
        {
            $commits_page++;
            $bb_commits = $api->call('https://api.bitbucket.org/2.0/repositories/'.$reformated_repositorie->full_name.'/commits',array('page'=>$commits_page,'pagelen'=>'100'));

            // Each value
            foreach($bb_commits->values as $_commit)
            {
                // Reformat and save
                $reformated_commit          = new stdClass();
                $reformated_commit->date    = $_commit->date;
                $reformated_commit->time    = strtotime($_commit->date);
                $reformated_commit->message = $_commit->message;

                if(!empty($_commit->author->user))
                {
                    $reformated_commit->author = $_commit->author->user->display_name;
                }
                else
                {
                    $reformated_commit->author = $_commit->author->raw;
                }

                $reformated_repositorie->commits[] = $reformated_commit;
            }

        } while(!empty($bb_commits->next));

        $repositories[] = $reformated_repositorie;
    }

} while(!empty($bb_repositories->next));

// Dates and times
$start_time   = strtotime('2015/01/01');
$end_time     = strtotime('2016/01/01');
$time_between = $end_time - $start_time;
$days_count   = $time_between / (24 * 60 * 60);

// Users
$all_users = array();
foreach($repositories as $_repository)
{
    // Each commit
    foreach($_repository->commits as $_commit)
    {
        // Between dates
        if($_commit->time > $start_time && $_commit->time < $end_time)
        {
            // Add
            if(!in_array($_commit->author, $all_users))
                $all_users[] = $_commit->author;
        }
    }
}

// $styles = array(
//     '#FF0095',
//     '#00FFE0',
//     '#81FF00',
//     '#FFFB00',
// );
$styles = array(
    '#FFFB00',
    '#B0FF00',
    '#00FF76',
    '#00FFE0',
    '#FF00E7',
    '#FF0072',
    '#FFB500',
);

$temp_users = array();
$users = array(
    array(
        'name'            => 'Charly Meignan',
        'bitbucket_names' => array('Charly Meignan')
    ),
    array(
        'name'            => 'Benoît Mars',
        'bitbucket_names' => array('Benoît Mars')
    ),
    array(
        'name'            => 'Bruno Charrier',
        'bitbucket_names' => array('bruno charrier <bruno@uzik.com>','bruno charrier')
    ),
    array(
        'name'            => 'Alexandre Pitton',
        'bitbucket_names' => array('Alexandre Pitton')
    ),
    array(
        'name'            => 'Romain Lévêque',
        'bitbucket_names' => array('Romain Lévêque')
    ),
    array(
        'name'            => 'Hélène Pruvot',
        'bitbucket_names' => array('Hélène Pruvot')
    ),
    array(
        'name'            => 'Antoine Grélard',
        'bitbucket_names' => array('Antoine Grélard')
    ),
    array(
        'name'            => 'Bruno Simon',
        'bitbucket_names' => array('Bruno Simon')
    ),
    array(
        'name'            => 'Thomas Le Gravier',
        'bitbucket_names' => array('Thomas Le Gravier','Thomas Le gravier')
    ),
    array(
        'name'            => 'Émilie Rozes',
        'bitbucket_names' => array('emilierozes <emilei.rozes@uzik.com>')
    ),
    array(
        'name'            => 'Robin Lambell',
        'bitbucket_names' => array('Robin Lambell')
    ),
    array(
        'name'            => 'Pierre Bellenger',
        'bitbucket_names' => array('PierreBellenger','Pierre Bellenger <pierrebellenger@iMac-de-Pierre-2.local>')
    ),
    array(
        'name'            => 'Maxime Maupeu',
        'bitbucket_names' => array('Maxime Maupeu')
    ),
    array(
        'name'            => 'Anthony Kim',
        'bitbucket_names' => array('Anthony Kim')
    ),
    array(
        'name'            => 'Jean-François Biondi',
        'bitbucket_names' => array('Jean-François Biondi <JFB@iMac-de-Romain.local>')
    ),
    array(
        'name'            => 'Louis Amiot',
        'bitbucket_names' => array('LouisJackson92 <louisamiot@iMac-de-Uzik.local>')
    ),
    array(
        'name'            => 'Bernard Vong',
        'bitbucket_names' => array('bernardVong','Bernard <bernard@iMac-de-Bernard.local>','Bernard Vong <vong.bernard@gmail.com>')
    ),
    array(
        'name'            => 'Kévin La Rosa',
        'bitbucket_names' => array('Kévin La Rosa <kevin.larosa@uzik.com>','La Rosa Kevin','Kévin La Rosa <larosa.kevin@gmail.com>')
    ),
    array(
        'name'            => 'Simon Duflos',
        'bitbucket_names' => array('Simon Dufos','simon6023 <simon.duflos@gmail.com>')
    ),
);

foreach($users as $_key => $_user)
{
    $users[$_key]['values'] = array();

    $users[$_key]['style'] = $styles[$_key % count($styles)];

    for($i = 0; $i < $days_count; $i++)
        $users[$_key]['values'][] = 0;
}

// Each repository
foreach($repositories as $_repository)
{
    // Each commit
    foreach($_repository->commits as $_commit)
    {
        // Between dates
        if($_commit->time > $start_time && $_commit->time < $end_time)
        {
            // In allowed
            foreach($users as $_key => $_user)
            {
                if(!in_array($_commit->author, $temp_users))
                    $temp_users[] = $_commit->author;

                if(in_array($_commit->author, $_user['bitbucket_names']))
                {
                    // Update value for day index
                    $day_index = floor(($_commit->time - $start_time) / (24 * 60 * 60));
                    $users[$_key]['values'][$day_index] = 1;
                }
            }
        }
        else
        {

        }
    }
}

// Organise
$data = new stdClass();
$data->sectors = $days_count;
$data->circles = $users;

// Cache
$cache = new Cache();
$cache->set('data',$data);

die('done');
