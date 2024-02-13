
<?php
if(isset($_GET['id'])):
    require_once('../database.php');
    $Database = new Database();
    $ticket = null;

    $question_response = null;
    if(isset($_GET['id'])){
        $ticket = $Database->get_data('ticket_id', $_GET['id'], 'ticket', true);
        if($ticket) $question_response = json_decode($ticket['ticket_response'], true);
    }
    if($ticket):
        //Update ticket views from follow-ups deadline
        //For ticket
        $sql = "UPDATE ticket_deadline SET viewed=1, emailed=1 WHERE ticket_id={$ticket['ticket_id']} AND end_date < CURDATE()";
        $update = $Database->get_connection()->prepare($sql);
        $update->execute();

        //For questions
        $sql = "UPDATE question_deadline SET viewed=1, emailed=1 WHERE ticket_id={$ticket['ticket_id']} AND end_date < CURDATE()";
        $update = $Database->get_connection()->prepare($sql);
        $update->execute();


if($user_permission || $company_permission || $admin_permission || $consultant_permission):
?>











<!-- Page: Review -->
<?php
    elseif(isset($_GET['page']) && $_GET['page'] == 'review'):
 ?>

<div class="card">
    <div class="card-body p-3">
    <div class="row user-content-row">
        <div class="col-12">
            <form>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><?php echo $trans->phrase("user_ticket_phrase2"); ?></div>
                    </div>
                    <input type="text" id="ticket_name" value="<?php echo ($ticket) ? $ticket['ticket_name']: ''; ?>" class="form-control" disabled>
                </div>
            </form>
        </div>
    </div>
    <?php

    $review = json_decode($ticket['ticket_review'], true);

    if(isset($review['review_status'])){
        $reviewStatus =  $review['review_status'];
        $reviewOptions = explode(",",$reviewStatus);
    }
    if(isset($review['review_text'])){
        $ticketReview = $review['review_text'];
    }

    $disabledStatus = '';

    if($ticket['review_status']=='1') {
        $disabledStatus = 'disabled';
    }

    if(!$user_permission) {
        $disabledStatus = 'disabled';
    }

    ?>
    <div class="row user-content-row">
        <div class="col-12">
            <form class="r-f-form">
                <label class="ticket-label"><?php echo $trans->phrase("user_ticket_phrase30"); ?></label><br>
                <div class="form-check">
                    <input class="form-check-input review-check"
                        type="checkbox" value="Anger"
                        <?php if(isset($reviewOptions)
                            && in_array("Anger",$reviewOptions)==1) {
                        echo "checked='checked'"; } ?>
                        id="review_check_1" <?php echo $disabledStatus; ?>>
                    <label class="form-check-label" for="review_check_1">
                        <?php echo $trans->phrase("user_ticket_phrase31"); ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input review-check"
                        type="checkbox" value="Fear"
                          <?php if(isset($reviewOptions)
                            && in_array("Fear",$reviewOptions)==1) {
                            echo "checked='checked'"; } ?>
                         id="review_check_2"
                         <?php echo $disabledStatus; ?>>
                    <label class="form-check-label" for="review_check_2">
                        <?php echo $trans->phrase("user_ticket_phrase32"); ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input review-check"
                        type="checkbox" value="Anxiety"
                        <?php if(isset($reviewOptions)
                            && in_array("Anxiety",$reviewOptions)==1) {
                        echo "checked='checked'"; } ?>
                        id="review_check_3"
                         <?php echo $disabledStatus; ?>>
                    <label class="form-check-label" for="review_check_3">
                        <?php echo $trans->phrase("user_ticket_phrase33"); ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input review-check"
                        type="checkbox" value="Loss"
                        <?php if(isset($reviewOptions)
                            && in_array("Loss",$reviewOptions)==1) {
                            echo "checked='checked'"; } ?>
                        id="review_check_4"
                        <?php echo $disabledStatus; ?>>
                    <label class="form-check-label" for="review_check_4">
                        <?php echo $trans->phrase("user_ticket_phrase34"); ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input review-check"
                        type="checkbox" value="Sadness"
                        <?php if(isset($reviewOptions)
                            && in_array("Sadness",$reviewOptions)==1) {
                        echo "checked='checked'"; } ?>
                        id="review_check_5"
                        <?php echo $disabledStatus; ?>>
                    <label class="form-check-label" for="review_check_5">
                        <?php echo $trans->phrase("user_ticket_phrase35"); ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input review-check"
                        type="checkbox" value="Resignation"
                        <?php if(isset($reviewOptions)
                            && in_array("Resignation",$reviewOptions)==1) {
                        echo "checked='checked'"; } ?>
                        id="review_check_6"
                        <?php echo $disabledStatus; ?>>
                    <label class="form-check-label" for="review_check_6">
                        <?php echo $trans->phrase("user_ticket_phrase36"); ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input review-check" type="checkbox"
                    value="Guilt"
                    <?php if(isset($reviewOptions)
                            && in_array("Guilt",$reviewOptions)==1) {
                        echo "checked='checked'"; } ?>
                    id="review_check_7"
                    <?php echo $disabledStatus; ?>>
                    <label class="form-check-label" for="review_check_7">
                        <?php echo $trans->phrase("user_ticket_phrase37"); ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input review-check"
                        type="checkbox" value="Shame"
                        <?php if(isset($reviewOptions)
                            && in_array("Shame",$reviewOptions)==1) {
                        echo "checked='checked'"; } ?>
                        id="review_check_8"
                        <?php echo $disabledStatus; ?>>
                    <label class="form-check-label" for="review_check_8">
                        <?php echo $trans->phrase("user_ticket_phrase38"); ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input review-check"
                        type="checkbox" value="Jealousy"
                        <?php if(isset($reviewOptions)
                            && in_array("Jealousy",$reviewOptions)==1) {
                        echo "checked='checked'"; } ?>
                        id="review_check_9"
                        <?php echo $disabledStatus; ?>>
                    <label class="form-check-label" for="review_check_9">
                        <?php echo $trans->phrase("user_ticket_phrase39"); ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input review-check"
                        type="checkbox" value="Enthusiasm"
                        <?php if(isset($reviewOptions)
                            && in_array("Enthusiasm",$reviewOptions)==1) {
                        echo "checked='checked'"; } ?>
                         id="review_check_10"
                         <?php echo $disabledStatus; ?>>
                    <label class="form-check-label" for="review_check_10">
                        <?php echo $trans->phrase("user_ticket_phrase40"); ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input review-check"
                        type="checkbox"
                        value="Tenderness"
                        <?php if(isset($reviewOptions)
                            && in_array("Tenderness",$reviewOptions)==1) {
                        echo "checked='checked'"; } ?>
                         id="review_check_11"
                         <?php echo $disabledStatus; ?>>
                    <label class="form-check-label" for="review_check_11">
                        <?php echo $trans->phrase("user_ticket_phrase41"); ?>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input review-check"
                        type="checkbox" value="Hope"
                        <?php if(isset($reviewOptions)
                            && in_array("Hope",$reviewOptions)==1) {
                        echo "checked='checked'"; } ?>
                        id="review_check_12"
                        <?php echo $disabledStatus; ?>>
                    <label class="form-check-label" for="review_check_12">
                        <?php echo $trans->phrase("user_ticket_phrase42"); ?>
                    </label>
                </div>
            </form>
        </div>
    </div>
    <div class="row user-content-row">
        <div class="col-12">
            <form>
            <label class="ticket-label"><?php echo $trans->phrase("user_ticket_phrase43"); ?></label>
                <textarea id="ticket_review">
                    <?php if(isset($ticketReview)) { echo $ticketReview; } ?>
                </textarea>
            </form>
        </div>
    </div>

    <div class="row col-12">
        <div class="col-3">
        </div>
        <div class="row col-6">
            <div class="col-3 d-flex flex-row-reverse">
                <a href="<?php echo SITE_URL ?>/user/index.php?route=ticket&id=<?php echo $ticket['ticket_id'] ?>&page=question&pageNum=7"
                        role="button"
                        class="btn btn-info btn-sm ml-1 mr-1 table-page-prev">
                    &nbsp;&nbsp;&nbsp;<i class="fas fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;
                </a>
            </div>
            <div class="col-6">
                <button  class="btn btn-info btn-sm table-page-number" style="width:100%">
                <span><?php echo $trans->phrase('text_review');?></span>
                </button>
            </div>
            <div class="col-3">
                    <a href="<?php echo SITE_URL ?>/user/index.php?route=ticket&id=<?php echo $ticket['ticket_id'] ?>&page=rating"
                        role="button"
                        class="btn btn-info btn-sm ml-1 mr-1 table-page-next">
                        &nbsp;&nbsp;&nbsp;<i class="fas fa-chevron-right"></i>&nbsp;&nbsp;&nbsp;
                </a>
            </div>
        </div>
        <div class="col-3">
        </div>
    </div>

    <div  class="row user-content-row" style="margin-top:1%">
        <?php
        if($ticket['review_status']!='1'
                && $user_permission) {
            if($ticket['ticket_status']=='closed') {
        ?>
            <button id="review_submit" class="btn btn-success"
                data-ticket_id="<?php echo $_GET['id']; ?>"
                data-ticket_review_status="1">
                <?php echo $trans->phrase("user_ticket_phrase44"); ?>
            </button>
        <?php
            }
            else {
                ?>
                  <button id="review_submit"
                  class="btn btn-success"
                  data-ticket_id="<?php echo $_GET['id']; ?>"
                  data-ticket_review_status="0">
                    <?php echo $trans->phrase("user_ticket_phrase15"); ?>
                  </button>
                <?php
            }
        }
        ?>
    </div>

    </div>
    </div>
    </div>

<!-- Page: ratting -->
<?php
    elseif(isset($_GET['page'])
        && $_GET['page'] == 'rating'):
?>

<div class="card">
    <div class="card-body p-3">
<div class="row user-content-row">
    <div class="col-12">
        <form>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">
                            <?php echo $trans->phrase("user_ticket_phrase1"); ?>
                    </div>
                </div>
                <input type="text" id="ticket_name"
                    value="<?php echo ($ticket) ? $ticket['ticket_name']: ''; ?>"
                    class="form-control" disabled>
            </div>
        </form>
    </div>
</div>

    <?php

        $rating = json_decode($ticket['ticket_rating'], true);

        $rating_check_1 = 0;
        $rating_check_2 = 0;
        $rating_check_3 = 0;
        $rating_check_4 = 0;

        $rating_text_1 = '';
        $rating_text_2 = '';

        if(isset($rating)) {
            $rating_check_1 = $rating['rating_check_1'];
            $rating_check_2 = $rating['rating_check_2'];
            $rating_check_3 = $rating['rating_check_3'];
            $rating_check_4 = $rating['rating_check_4'];

            $rating_text_1 = $rating['rating_text_1'];
            $rating_text_2 = $rating['rating_text_2'];
        }

        $ratingStatus = '0';
        if(!$user_permission) {
            $ratingStatus = '1';
        }
        else {
            $ratingStatus = $ticket['rating_status'];
        }

    ?>
    <div class="row user-content-row">
        <input type="hidden" id="rating_status_value" name="rating_status_value"
            value="<?php echo $ratingStatus; ?>"/>
        <div class="col-12">
        <form>
            <label class="ticket-label"><?php echo $trans->phrase("user_ticket_phrase47"); ?></label><br>
            <div id="rating_check_1" class="smiley-check">
                <i class="far fa-frown <?php if($rating_check_1==1) echo "active" ?>"></i>
                <i class="far fa-frown-open <?php if($rating_check_1==2) echo "active" ?>"></i>
                <i class="far fa-meh <?php if($rating_check_1==3) echo "active" ?>"></i>
                <i class="far fa-smile <?php if($rating_check_1==4) echo "active" ?>"></i>
                <i class="far fa-grin <?php if($rating_check_1==5) echo "active" ?>"></i>
            </div>
            <br>
            <label class="ticket-label"><?php echo $trans->phrase("user_ticket_phrase48"); ?></label><br>
            <div id="rating_check_2" class="smiley-check">
                <i class="far fa-frown <?php if($rating_check_2==1) echo "active" ?>"></i>
                <i class="far fa-frown-open <?php if($rating_check_2==2) echo "active" ?>"></i>
                <i class="far fa-meh <?php if($rating_check_2==3) echo "active" ?>"></i>
                <i class="far fa-smile <?php if($rating_check_2==4) echo "active" ?>"></i>
                <i class="far fa-grin <?php if($rating_check_2==5) echo "active" ?>"></i>
            </div><br>
            <label class="ticket-label"><?php echo $trans->phrase("user_ticket_phrase49"); ?></label><br>
            <div id="rating_check_3" class="smiley-check">
                <i class="far fa-frown <?php if($rating_check_3==1) echo "active" ?>"></i>
                <i class="far fa-frown-open <?php if($rating_check_3==2) echo "active" ?>"></i>
                <i class="far fa-meh <?php if($rating_check_3==3) echo "active" ?>"></i>
                <i class="far fa-smile <?php if($rating_check_3==4) echo "active" ?>"></i>
                <i class="far fa-grin <?php if($rating_check_3==5) echo "active" ?>"></i>
            </div><br>
            <label class="ticket-label"><?php echo $trans->phrase("user_ticket_phrase50"); ?></label><br>
            <div id="rating_check_4" class="smiley-check">
                <i class="far fa-frown <?php if($rating_check_4==1) echo "active" ?>"></i>
                <i class="far fa-frown-open <?php if($rating_check_4==2) echo "active" ?>"></i>
                <i class="far fa-meh <?php if($rating_check_4==3) echo "active" ?>"></i>
                <i class="far fa-smile <?php if($rating_check_4==4) echo "active" ?>"></i>
                <i class="far fa-grin <?php if($rating_check_4==5) echo "active" ?>"></i>
            </div>
        </form>
    </div>
</div>
    <div class="row user-content-row">
    <div class="col-12">
        <form>
        <label class="ticket-label"><?php echo $trans->phrase("user_ticket_phrase51"); ?></label>
            <textarea id="rating_text_1">
            </textarea>
        </form>
    </div>
</div>
<div class="row user-content-row">
    <div class="col-12">
        <form>
        <label class="ticket-label"><?php echo $trans->phrase("user_ticket_phrase52"); ?></label>
            <textarea id="rating_text_2">
            </textarea>
        </form>
    </div>
</div>

<div class="row col-12">
        <div class="col-3">
        </div>
        <div class="row col-6">
            <div class="col-3 d-flex flex-row-reverse">
                <a href="<?php echo SITE_URL ?>/user/index.php?route=ticket&id=<?php echo $ticket['ticket_id'] ?>&page=review"
                        role="button"
                        class="btn btn-info btn-sm ml-1 mr-1 table-page-next">
                        &nbsp;&nbsp;&nbsp;<i class="fas fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;
                </a>
            </div>
            <div class="col-6">
                <button class="btn btn-info btn-sm table-page-number" style="width:100%">
                    <span><?php echo $trans->phrase('text_rating');?></span>
                </button>
            </div>
        </div>
        <div class="col-3">
        </div>
    </div>
    </div>
    </div>

    <?php

    $answerCount = 0;
    $countNotFollowUpQuestion = 0;

    $questionsList = $Database->get_multiple_data(false, false, 'question');
    if($questionsList) {
        foreach($questionsList as $questionData) {
            if($questionData['question_follow_up']==0) {
                $countNotFollowUpQuestion++;
            }
        }
    }

    $response = $ticket['ticket_response'];
    if($response) {
        $response_array = json_decode($response, true);
        foreach($response_array as $q_id => $resp) {
            if(isset($resp['answer'])
                && $resp['answer']
                && !$resp['follow-up']) {
                $answerCount++;
            }
        }
    }

    ?>

<div class="card">
    <div class="card-body p-3">

    <div  class="row user-content-row" style="justify-content:center;">
        <?php
        if($ticket['rating_status']!='1'
                        && $user_permission) {
            if($ticket['ticket_status']=='closed') {
        ?>
            <button id="rating_submit" class="btn btn-success mb-3 ml-3"
                style = "width:150px;"
                data-ticket_id="<?php echo $_GET['id']; ?>"
                data-ticket_rating_status="1">
                <?php echo $trans->phrase("user_ticket_phrase44"); ?>
            </button>
            <?php
            }
            else {
                ?>
                  <button id="rating_submit"
                    class="btn btn-success  mb-3 ml-3"
                    style = "width:150px;"
                    data-ticket_id="<?php echo $_GET['id']; ?>"
                    data-ticket_rating_status="0">
                    <?php echo $trans->phrase("user_ticket_phrase15"); ?>
                  </button>
                <?php
            }

            if($answerCount>=$countNotFollowUpQuestion
                && $ticket['ticket_status']!='closed') {
            ?>
                   <button id="close_ticket"
                           class="btn btn-info  mb-3 ml-3"
                           style = "width:150px;"
                           data-ticket_id="<?php echo ($ticket) ? $ticket['ticket_id']: ''; ?>">
                        <?php echo $trans->phrase("user_ticket_phrase16"); ?>
                    </button>
                <?php

                }
        }
        ?>
    </div>
    </div>
    </div>

<?php endif; ?> <!-- Pages -->
<?php
        else:
            echo "You are not authorized to view this report!";
        endif; //User permission endif
    else:
        echo "Content not found!";
    endif; //Ticket exist endif

//New ticket
elseif($_SESSION['account-type'] == 'user'):

      if(isset($_GET['page']) && $_GET['page'] == 'reporttype'):
          ?>
          <div class="container">
          <div class="row">
  <div class="col-3"><a href="?route=ticket&page=requestreport&type=mainreport"><img src="<?php echo SITE_URL ?>/images/generic-image-placeholder.png"/><span style="margin-left:35%;">Main Report </span></a></div>
  <div class="col-3"><a href="?route=ticket&page=requestreport&type=duoreport"><img src="<?php echo SITE_URL ?>/images/generic-image-placeholder.png"/><span style="margin-left:35%;">Duo Report </span></a></div>
  <div class="col-3"><a href="?route=ticket&page=requestreport&type=leaderprofile"><img src="<?php echo SITE_URL ?>/images/generic-image-placeholder.png"/><span style="margin-left:35%;">Leader Profile </span></a></div>
   <div class="col-3"><a href="?route=ticket&page=requestreport&type=employeeprofile"><img src="<?php echo SITE_URL ?>/images/generic-image-placeholder.png"/><span style="margin-left:35%;">Employee Profile </span></a></div>
</div>
</div>
<?php


          endif;



           if(isset($_GET['page']) && $_GET['page'] == 'requestreport'):
          ?>

          <div class="container">
          <div class="row">

<div class = "radio">
     <label for = "name">Submit Report To :</label></div>
      <div class = "radio">

           <input class="form-check-input--" type="radio" name="submitto"  value="company" checked/>  <label>Company
         </label>
      </div>
      <div class = "radio">
         <label>
          <input class="form-check-input--" type="radio" name="submitto"  value="consultant"  />
              <span>Consultant</span>
         </label>
      </div>
  </div>
  </div>



 <?php


$user_data= $Database->get_data_new('user_id', $_SESSION['account-id'], 'user', true);

 $company_id= $user_data['user_company_id'];
//echo $company_email= $user_data['user_7email'];

$company_data= $Database->get_data_new('company_id', $company_id, 'company', true);
 $company_data['company_email'];

$coonsultant_data= $Database->get_data_new('consultant_companies', $company_id, 'consultant', true);
 $coonsultant_data['tfa_email'];


?>
<input type="hidden" namne="reporttype" id="reporttype" value="<?php echo $_GET['type'] ;?>">

<input type="hidden" namne="company_email" id="company_email" value="<?php echo $company_data['company_email'] ;?>">
<input type="hidden" namne="company_id" id="company_id" value="<?php echo $company_data['company_id'] ;?>">

<input type="hidden" namne="consultant_id" id="consultant_id" value="<?php echo $company_data['consultant_id'] ;?>">


<input type="hidden" namne="consultant_email" id="consultant_email" value="<?php echo $coonsultant_data['consultant_email'] ;?>">
<input type="hidden" namne="user_id" id="user_id" value="<?php echo $_SESSION['account-id'] ;?>">

 <button id="submitreportrequest" class="btn btn-success">
               Send Request
            </button>


<?php


          endif;










if(isset($_GET['page']) && $_GET['page'] == 'summarize'):
if(isset($_GET['req_id'])){
$_SESSION['ticket_request_id'] = $_GET['req_id'];
}
/*if(isset($_GET['nareq_id'])){
$_SESSION['ticket_narequest_id'] = $_GET['nareq_id'];
}*/
?>
<?php
  $user_id = $_SESSION['account-id'];

?>

<div class="card">
    <div class="card-body p-3">
<div class="row user-content-row">
    <div class="col-12">
        <form>
            <label class="ticket-label"><?php echo $trans->phrase("user_ticket_phrase23"); ?></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><?php echo $trans->phrase("user_ticket_phrase1"); ?></div>
                </div>
                <input type="text" id="ticket_name" class="form-control">
            </div>
        </form>
    </div>
</div>
<div class="row user-content-row">
    <div class="col-12">
        <form>
        <label class="ticket-label"><?php echo $trans->phrase("user_ticket_phrase25"); ?></label>
            <textarea id="ticket_summary"></textarea>
        </form>
    </div>
</div>
<div class="row user-content-row">
    <button id="create_ticket" class="btn btn-success mb-3 ml-3" data-ticket_id="">
        <?php echo $trans->phrase("user_ticket_phrase24"); ?>
    </button>
</div>
    </div>
    </div>

<?php
 endif;









if(isset($_GET['page']) && $_GET['page'] == 'summarize1'): ?>

<?php
  $user_id = $_SESSION['account-id'];


  $is_report = count($Database->get_data_by_query("SELECT * FROM tbl_report_request WHERE status='0' AND user_id={$user_id}"));
 $flag=false;
 if($is_report > 0)
 {
     $flag=true;
 ?>
    <div class="card">
        <div class="card-body p-3">
            <div class="row user-content-row request_form">
                <div class="col-12" style="text-align: center;color: green;">
                    <h2 style="color: green;">You have submitted Your report for permission. Please wait sometime for approvel.</h>
                </div>
            </div>
        </div>
 <?php

 }


 $is_report = count($Database->get_data_by_query("SELECT * FROM tbl_report_request WHERE status IN ('0','1') AND user_id={$user_id}"));
 if($flag==false && $is_report == 0)
 {
 $flag=true;
 ?>
<div class="card">
    <div class="card-body p-3">
<div class="row user-content-row request_form">
    <div class="col-12">
        <form>
            <input type="hidden" name="request_form_id" id="request_form_id" value="1">
            <div class="input-group">
                <div style="display: contents;">
                    <!-- section 1 start -->
                    <div class="col-xs-3 click_select_report" attr-val="1" style="cursor: pointer;">
                        <div class="data-section col-xs-12">
                            <div class="image-section col-xs-12" style="padding: 10px;padding-bottom: 1px;">
                                <img src="https://alexsol.tk<?php echo SITE_URL ?>/images/report_image1.png">
                            </div>
                            <div class="text-section col-xs-12" style="text-align: center;font-weight:bold;border: 1px solid;height: 40px;
    margin: 0px 11px;">
                                Image 1
                            </div>
                        </div>
                    </div>
                    <!-- section 1 end -->
                     <!-- section 2 start -->
                    <div class="col-xs-3 click_select_report" attr-val="2" style="cursor: pointer;">
                        <div class="data-section col-xs-12">
                            <div class="image-section col-xs-12" style="padding: 10px;padding-bottom: 1px;">
                                <img src="https://alexsol.tk<?php echo SITE_URL ?>/images/report_image1.png">
                            </div>
                            <div class="text-section col-xs-12" style="text-align: center;font-weight:bold;border: 1px solid;height: 40px;
    margin: 0px 11px;">
                                Image 2
                            </div>
                        </div>
                    </div>
                    <!-- section 2 end -->
                     <!-- section 3 start -->
                    <div class="col-xs-3 click_select_report" attr-val="3" style="cursor: pointer;">
                        <div class="data-section col-xs-12">
                            <div class="image-section col-xs-12" style="padding: 10px;padding-bottom: 1px;">
                                <img src="https://alexsol.tk<?php echo SITE_URL ?>/images/report_image1.png">
                            </div>
                            <div class="text-section col-xs-12" style="text-align: center;font-weight:bold;border: 1px solid;height: 40px;
    margin: 0px 11px;">
                                Image 3
                            </div>
                        </div>
                    </div>
                    <!-- section 3 end -->
                     <!-- section 4 start -->
                    <div class="col-xs-3 click_select_report" attr-val="4" style="cursor: pointer;">
                        <div class="data-section col-xs-12">
                            <div class="image-section col-xs-12" style="padding: 10px;padding-bottom: 1px;">
                                <img src="https://alexsol.tk<?php echo SITE_URL ?>/images/report_image1.png">
                            </div>
                            <div class="text-section col-xs-12" style="text-align: center;font-weight:bold;border: 1px solid;height: 40px;
    margin: 0px 11px;">
                                Image 4
                            </div>
                        </div>
                    </div>
                    <!-- section 4 end -->


                </div>
            </div>
        </form>
    </div>
</div>
<div class="col-xs-6">
    <div class="col-12">
        <label class="ticket-label">Permission by:</label>
        <input type="radio" checked="checked" name="permission_by" id="permission_by" value="0"> Company
        <input type="radio" name="permission_by" id="permission_by" value="1"> Consultancy
    </div>
</div>
<div class="col-xs-6">
    <button id="request_from_ticket" class="btn btn-success mb-3 ml-3" data-ticket_id="">
        <?php echo $trans->phrase("user_ticket_phrase59"); ?>
    </button>
</div>

    </div>
    </div>

  <script type="text/javascript">
        $(document).ready(function() {
                $('.click_select_report').click(function(){
                    $('.select_report').removeClass();
                    $('#request_form_id').val($(this).attr('attr-val'));
                    $(this).addClass('select_report');
                });

    //Create ticket
    $('#request_from_ticket').click(function (event) {
        event.preventDefault();

        let request_form_id = $('#request_form_id').val();
        let permission_by = $("input[name='permission_by']:checked").val();



            $.ajax({
                url: '<?php echo SITE_URL ?>/option_server.php',
                type: 'POST',
                data: {'sign': 'request_form', 'request_form_id': request_form_id, 'permission_by': permission_by}
            }).done(function (data) {
                data = JSON.parse(data);
                if (data['status'] == 'success') {
                    window.location.href = "<?php echo SITE_URL ?>/user/index.php?route=ticket&page=summarize1";
                } else {
                    alert(data['message']);
                }
            })

    });
        });

</script>

<?php  }
 if($flag==false) header("Location: index.php?route=ticket&page=summarize");

    endif;
else:
    echo "Content not found!";
endif;  //ID set endif
?>











<?php if(isset($_GET['page']) && $_GET['page'] == 'nticket') {


if(!isset($_SESSION['trans'])){
    $Database = new Database();
    $default_language = $Database->get_data('lang_default', 1, 'language', true);
    if($default_language){
        $_SESSION['trans'] = $default_language['lang_code'];
    }
    else{
        $_SESSION['trans'] = 'en';
    }
}

$report_data = $Database->get_multiple_data('report_lang_code', $_SESSION['trans'], 'mlreport_format_content');
?>



<div class="card">
    <div class="card-body p-3">
<div class="row user-content-row request_form">
    <div class="col-12">
        <form>
            <input type="hidden" name="request_form_id" id="request_form_id" value="1">
            <div class="input-group">
                <div style="display: contents;">
                  <?php
                  if ($report_data) {
                  $i = 1;
                  foreach ($report_data as $report_format) {
                  ?>
                    <!-- section 1 start -->
                    <div class="col-xs-3 click_select_report <?php if($i == 1)  { ?>select_report<?php } ?>" attr-val="<?php echo $report_format['report_format_id'];  ?>" style="cursor: pointer;">
                         <?php if($i == 1)  { ?>
                        <script>
                            $('#request_form_id').val(<?php echo $report_format['report_format_id'];  ?>);
                        </script>
                         <?php } ?>
                        <div class="data-section col-xs-12">
                            <div class="image-section col-xs-12" style="padding: 10px;padding-bottom: 1px;">
                                <img src="<?php echo SITE_URL ?>/images/report_image/<?php echo $report_format['report_image']  ?>" style="height: 317px;width: 230px;">
                            </div>
                            <div class="text-section col-xs-12" style="font-size: 23px;text-align: center;font-weight:bold;border: 1px solid;height: 40px;
    margin: 0px 11px;">
                                <?php echo $report_format['report_title']  ?> <button data-bs-toggle="modal" onclick="return false;" data-bs-target="#exampleModalPen_<?php echo $report_format['report_format_id']; ?>" class="btn"><i class="fas fa-info-circle"></i></button>
                            </div>
                        </div>
                    </div>

    <div class="modal fade" id="exampleModalPen_<?php echo $report_format['report_format_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title text-center" style="margin: 0px auto;" id="exampleModalLabel"><?php echo $report_format['report_title']  ?> details</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  </div>
		  <div class="modal-body" id="">
		            <?php echo htmlspecialchars_decode($report_format['report_desc']); ?>
		  </div>
		</div>
	  </div>
	</div>

                   <?php

                       $i++;
                  }
                   } ?>

                </div>
            </div>
        </form>
    </div>
</div>
<div class="col-xs-6">
    <div class="col-12">
        <form>
            <label class="ticket-label"><?php echo $trans->phrase("create_ticket_personal"); ?> :</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><?php echo $trans->phrase("permisson_ticket_name"); ?></div>
                </div>
                <input type="text" id="permisson_ticket_title" class="form-control">
            </div>
        </form>
    </div>
</div>
<br>
<div class="col-xs-6">
    <div class="col-12">
        <label class="ticket-label"><?php echo $trans->phrase("permission_by"); ?> :</label>
        <input type="radio" name="permission_by" id="permission_by_company" value="0"><?php echo $trans->phrase("company_text"); ?>
        <input type="radio" name="permission_by" id="permission_by_consultancy" value="1"><?php echo $trans->phrase("consultancy_text"); ?>
    </div>
</div>
<div class="col-xs-6">
    <button id="request_from_ticket" class="btn btn-success mb-3 ml-3" data-ticket_id="">
        <?php echo $trans->phrase("user_ticket_phrase59"); ?>
    </button>
</div>
<div style="display:none;" id="alertSectionemptyptitle"><span id="alertSection" style="color: red;"><?php echo $trans->phrase("permisson_tite_text"); ?></span></div>
    </div>
    </div>


<?php } ?>







<?php if(isset($_GET['page']) && $_GET['page'] == 'nticket_success') { ?>
<div class="card">
        <div class="card-body p-3">
            <div class="row user-content-row request_form">
                <div class="col-12" style="text-align: center;color: green;">
                    <h2 style="color: green;">You have submitted Your report for permission. Please wait sometime for approvel.</h>
                </div>
            </div>
        </div>
<?php } ?>
