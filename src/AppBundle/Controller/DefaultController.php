<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
        ]);
    }
    /**
     * @Route("/datas", name="datas")
     */
    public function datasAction(Request $request){

        $at = $request->query->get('date', date('Y-m-d'));

        if (false === $datetime = \DateTime::createFromFormat('Y-m-d', $at)){
            return new JsonResponse(['date'=>$at, 'error'=>'Invalide date. Format : yyyy-mm-dd'],400);
        }
        $conn = $this->get('database_connection');

        $bornes = $conn->query("SELECT min(at) as start, max(at) as end from releve");

        $bornes_query = $conn->prepare("SELECT min(at) as start, max(at) as end from releve WHERE at like :date AND hchc != '' AND hchp != ''");
        $bornes_query->bindValue(':date', $at.'%');
        $bornes_query->execute();

        $datas = $conn->prepare("SELECT * FROM releve WHERE at like :date AND hchc != '' AND hchp != '' ORDER BY at ASC");
        $datas->bindValue(':date', $at.'%');

        $datas->execute();

        $datasRun = [];
        $hchp = 0;
        $hchc = 0;

        $totalHp=0.0;
        $totalHc=0.0;

        while ($ligne = $datas->fetch()) {
            if($ligne['hchc'] > $hchc && $hchc > 0){
                $ligne['hchc_diff'] = doubleval($ligne['hchc']) - $hchc;
            } else {
                $ligne['hchc_diff'] = 0;
            }
            $hchc = doubleval($ligne['hchc']);
            if($ligne['hchp'] > $hchp && $hchp > 0){
                $ligne['hchp_diff'] = doubleval($ligne['hchp']) - $hchp;
                
            } else {
                $ligne['hchp_diff'] = 0;
            }
            $hchp = doubleval($ligne['hchp']);
            //$datasRun[] = $ligne;
            $datasRun['HC'][]=($ligne['hchc_diff']>0.0)?$ligne['hchc_diff']:null;
            $datasRun['HP'][]=($ligne['hchp_diff']>0.0)?$ligne['hchp_diff']:null;
            $datasRun['I'][]=(doubleval($ligne['iinst'])>0.0)?doubleval($ligne['iinst']):null;
            $h = explode(' ', $ligne['at']);
            $datasRun['xAxis'][]=end($h);
            $totalHc+=$ligne['hchc_diff'];
            $totalHp+=$ligne['hchp_diff'];
        }

        return new JsonResponse(['date'=>$at, 'borne_globales'=>$bornes->fetch(), 'borne_datas'=>$bornes_query->fetch(), 'total_datas'=>['hc'=>$totalHc, 'hp'=>$totalHp],'datas'=>$datasRun]);
    }

}
