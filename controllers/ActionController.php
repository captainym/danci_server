<?php
/**
 * Created by IntelliJ IDEA.
 * User: yuanxijie
 * Date: 13-10-27
 * Time: 下午8:44
 * To change this template use File | Settings | File Templates.
 */ 
class ActionController extends Controller {
    private static $OP_TYPES = array(
        '1'=>'StudyOperationTypeSeletTipImg',
        '2'=>'StudyOperationTypeSelectTipTxt',
        '3'=>'StudyOperationTypeEditTip',
        '10'=>'StudyOperationTypeFeedbackOk',
        '11'=>'StudyOperationTypeFeedbackFuzzy',
        '12'=>'StudyOperationTypeFeedbackNagative'
    ) ;
    public function actionRegister() {
        $this->logger->info('start to register user', $_POST);
        $rs = $this->user->add_user($_POST);
        $this->logger->info('end to register user', $rs);

        echo json_encode($rs);
    }

    public function actionAuth() {
        $this->logger->info('start to auto user', $_POST);
        $rs = $this->user->auth($_POST);
        $this->logger->info('end to auth user', $rs);
        echo json_encode($rs);
    }

    public function actionOp() {
        $this->logger->info('receive op :', $_POST);

        $op_type = intval(trim($_POST['otype']));
        $op_value = $_POST['ovalue'];
        $op_time = $_POST['opt_time'];
        $studyNo = $_POST['studyNo'];
        $word = $_POST['word'];
        $data = array(
            'word'=>trim($word),'studyNo'=>intval(trim($studyNo)),
            'create_time'=>intval(trim($op_time))
        );
        $rs = $this->tips->arrayResult(0, 'ok');
        switch($op_type) {
            case 1: //StudyOperationTypeSeletTipImg
                {
                    $img_key = $op_value;
                    $this->tips->adopt_img($word, $img_key);
                    break;
                }
            case 2: //StudyOperationTypeSelectTipTxt
            {
                $tip_id = $op_value;
                $this->tips->adopt_txt($word, $tip_id);
                break;
            }
            case 3: //StudyOperationTypeEditTip
            {
                $data['tip_txt'] = $op_value;
                $rs = $this->tips->add_txt_tip($data);
                break;
            }
            case 10: //StudyOperationTypeFeedbackOk
            case 11: //StudyOperationTypeFeedbackFuzzy
            case 12: //StudyOperationTypeFeedbackNagative
            {
                $data['feedback_type'] = $op_type;
                $rs = $this->action->add_feedback($data);
                break;
            }
            default:
                $rs = $this->tips->arrrayResult(1, 'operation type:' . $op_type . ' not support');
                break;
        }
        $this->logger->info('operation response:', $rs);
        echo json_encode($rs);
    }
}
