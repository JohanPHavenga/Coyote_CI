<!-- BEGIN: PAGE CONTAINER -->
<div class="c-layout-page">
    <?= $title_bar; ?>
    <!-- BEGIN: PAGE CONTENT -->

    <div class="c-content-box c-size-sm">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <b>parkrun</b> organise free, weekly, 5km timed runs around the world. They are open to everyone, <b>free</b>, and are safe and easy to take part in.</p>
                        <p>These events take place in pleasant parkland surroundings and we encourage people of every ability to take part; 
                            from walkers or those taking their first steps in running to Olympians; from juniors to those with more experience; we welcome you all!</p>
                    </p>
                    <?php
                    $this->table->set_template(ftable('parkrun_table'));
                    $heading=["Name","Town","Contact"];
                    $this->table->set_heading($heading);
                    foreach ($parkrun_list as $id=>$parkrun) {
                        $url=get_url_from_parkrun_name(encode_parkrun_name($parkrun['parkrun_name']));
                        $this->table->add_row(
                                $parkrun['parkrun_name'], 
                                $parkrun['town_name'], 
                                $parkrun['user_email']
//                               '<a href="'. $url.'" class="btn btn-primary btn-xs c-btn-uppercase">More</a>'
                                );
//                        $this->table->add_row($row);
                        unset($row);
                    }
                    echo $this->table->generate();
                    ?>
                </div>
            </div>
        </div>
    </div>
    
</div>


