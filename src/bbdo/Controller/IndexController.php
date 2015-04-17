<?php
/**
 * Created by PhpStorm.
 * User: Steven
 * Date: 25-02-2015
 * Time: 22:20
 */
namespace bbdo\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class IndexController
{
    public function indexAction(Application $app)
    {
        $limit = 1;
        $offset = 0;
        $OneOrderBy = array('created_at' => 'DESC');
        $newsNotices = $app['repository.notice']->findAll($limit, $offset, $OneOrderBy);
        $groupSize = 1;
        $groupedNewsNoticeOne = array();
        $progress = 0;
        while ($progress < $limit) {
            $groupedNewsNoticeOne[] = array_slice($newsNotices, $progress, $groupSize);
            $progress += $groupSize;
        }

        $limit = 1;
        $offset = 1.1;
        $TwoOrderBy = array('created_at' => 'DESC');
        $newsNotices = $app['repository.notice']->findAll($limit, $offset, $TwoOrderBy);
        $groupSize = 1;
        $groupedNewsNoticeTwo = array();
        $progress = 0;
        while ($progress < $limit) {
            $groupedNewsNoticeTwo[] = array_slice($newsNotices, $progress, $groupSize);
            $progress += $groupSize;
        }

        $limit = 1;
        $offset = 2.1;
        $ThreeOrderBy = array('created_at' => 'DESC');
        $newsNotices = $app['repository.notice']->findAll($limit, $offset, $ThreeOrderBy);
        $groupSize = 1;
        $groupedNewsNoticeThree = array();
        $progress = 0;
        while ($progress < $limit) {
            $groupedNewsNoticeThree[] = array_slice($newsNotices, $progress, $groupSize);
            $progress += $groupSize;
        }

        $limit = 1;
        $offset = 3.1;
        $FourOrderBy = array('created_at' => 'DESC');
        $newsNotices = $app['repository.notice']->findAll($limit, $offset, $FourOrderBy);
        $groupSize = 1;
        $groupedNewsNoticeFour = array();
        $progress = 0;
        while ($progress < $limit) {
            $groupedNewsNoticeFour[] = array_slice($newsNotices, $progress, $groupSize);
            $progress += $groupSize;
        }
        $birthday = $app['repository.user']->birthDay();
        return $app['twig']->render('home/index.html.twig', array(
            'birthday' => $birthday,
            'groupedNewsNoticeOne' => $groupedNewsNoticeOne,
            'groupedNewsNoticeTwo' => $groupedNewsNoticeTwo,
            'groupedNewsNoticeThree' => $groupedNewsNoticeThree,
            'groupedNewsNoticeFour' => $groupedNewsNoticeFour,

        ));
    }

    public function viewdirectoryAction(Request $request, Application $app)
    {
        $b = "Directorio";
        $total = $app['repository.user']->getCount();
        $limit = $total;
        $numPages = ceil($total / $limit);
        $currentPage = $request->query->get('page', 1);
        $offset = ($currentPage - 1) * $limit;
        $userview = $app['repository.user']->findAll($limit, $offset);
        //var_dump($userview) or die();
        return $app['twig']->render('home/directory.html.twig', array(
            'userview' => $userview,
            'currentPage' => $currentPage,
            'numPages' => $numPages,
            'here' => $app['url_generator']->generate('bbdo_directory'),
            'b' => $b,
        ));

    }

    public function vieworganizationchartAction(Application $app)
    {
        return $app['twig']->render('home/organizationchart.html.twig', array());
    }
}