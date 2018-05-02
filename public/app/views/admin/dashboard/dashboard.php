<div class="row">
    <?php
    if (isset($dashboard_stats_list)) {
        foreach ($dashboard_stats_list as $stat) {
            ?>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="dashboard-stat2 ">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-<?= $stat['font-color'];?>">
                                    <span data-counter="counterup" data-value="" class="counter"><?= $stat['number'];?></span>
                                </h3>
                                <small><?= strtoupper($stat['text']);?></small>
                            </div>
                            <div class="icon">
                                <i class="<?= $stat['icon'];?>"></i>
                            </div>
                        </div>
                        <div class="progress-info">
                            <a href="<?= $stat['uri'];?>" class="btn btn-default btn-xs <?= $stat['font-color'];?>">View</a>
<!--                            <div class="progress">
                                <span style="width: 76%;" class="progress-bar progress-bar-success green-sharp">
                                    <span class="sr-only">76% progress</span>
                                </span>
                            </div>
                            <div class="status">
                                <div class="status-title"> progress </div>
                                <div class="status-number"> 76% </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            <?php
        }
    }
    ?>
</div>


<div class="row">
    <div class="col-md-6">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-rocket"></i>
                    <span class="bold"> Events with unconfirmed data</span>
                </div>
            </div>
            <div class="portlet-body">
                <?php
                // create table
                $this->table->set_template(ftable('editions_unconfirmed_table'));
                foreach ($event_list_unconfirmed as $month=>$edition_list) {
                    $this->table->add_row(["<b>$month</b>"]);
                    foreach ($edition_list as $edition) {
                        $row['id']=$edition['edition_id'];
                        $row['name']="<a href='/admin/edition/create/edit/".$edition['edition_id']."'>".$edition['edition_name']."</a>";
                        $row['date']=fdateShort($edition['edition_date']);   
                        
                        
                        $email_link='/admin/mailer/info_mail/'.$edition['edition_id'];
                        if ($edition['user_email']) {
                            if ($edition['edition_info_email_sent']) {
                                $row['info_email']='<a href="'.$email_link.'" class="btn btn-xs default" data-toggle="confirmation" data-original-title="Are you sure you want to resend the email? '.$edition['user_email'].'"><i class="fa fa-envelope-o"></i> Resend Email</a>';                            
                            } else {
                                $row['info_email']='<a href="'.$email_link.'" class="btn btn-xs blue" data-toggle="confirmation" data-original-title="Confirm send email to organiser? '.$edition['user_email'].'"><i class="fa fa-envelope-o"></i> Send Email</a>';
                            }
                        } else {
                            $row['info_email']='<a class="btn btn-xs red" title="Add contact to event to send email"><i class="fa fa-user"></i> No contact</a>';
                        }
                        $this->table->add_row($row);
                        unset($row);
                    }
                }
                echo $this->table->generate();
                ?>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="portlet light">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-rocket"></i>
                    <span class="bold"> Events with no results</span>
                </div>
            </div>
            <div class="portlet-body">
                <?php
                // create table
                $this->table->set_template(ftable('editions_noresults_table'));
                foreach ($event_list_noresults as $month=>$edition_list) {
                    $this->table->add_row(["<b>$month</b>"]);
                    foreach ($edition_list as $edition) {
                        $row['id']=$edition['edition_id'];
                        $row['name']="<a href='/admin/edition/create/edit/".$edition['edition_id']."'>".$edition['edition_name']."</a>";
                        $row['date']=fdateShort($edition['edition_date']);                        
//                        $row['info_email']=$edition['edition_info_email_sent'];
                        $this->table->add_row($row);
                        unset($row);
                    }
                }
                echo $this->table->generate();
                ?>
            </div>
        </div>
    </div>
</div>

<?php
//wts($event_list_unconfirmed);
?>            
