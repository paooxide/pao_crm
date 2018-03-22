

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>DASHBOARD</h2>
            </div>

            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-pink hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">playlist_add_check</i>
                        </div>
                        <div class="content">
                            <div class="text">NEW CAMPAIGN</div>
                            <div class="number count-to" data-from="0" data-to="125" data-speed="15" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-cyan hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">event_available</i>
                        </div>
                        <div class="content">
                            <div class="text">YOUR EVENTS</div>
                            <div class="number count-to" data-from="0" data-to="257" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-light-green hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">forum</i>
                        </div>
                        <div class="content">
                            <div class="text">NEW COMMENTS</div>
                            <div class="number count-to" data-from="0" data-to="243" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box bg-orange hover-expand-effect">
                        <div class="icon">
                            <i class="material-icons">contact_mail</i>
                        </div>
                        <div class="content">
                            <div class="text">REFER CLIENT</div>
                            <div class="number count-to" data-from="0" data-to="1225" data-speed="1000" data-fresh-interval="20"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Widgets -->
            <!-- CPU Usage -->

            <!-- #END# CPU Usage -->


            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                REQUEST LOGS
                            </h2> <br><br>
                            <?php if (isset($message)): ?>
                              <?=$message;?>
                            <?php endif; ?>

                        </div>
                        <div class="body">
                            <div class="body table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>S/NO</th>
                                        <th>Type</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Company</th>
                                        <th>Time</th>
                                        <th>Treated</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $i = 1; foreach ($mission as $miss): ?>
                                    <tr>
                                        <th scope="row"><?=$i?></th>
                                        <td><?=$miss->mission?></td>
                                        <td><?=$miss->subject?></td>
                                        <td><?=$miss->body?></td>
                                        <td><?=$miss->company?></td>
                                        <td><?=date("D, M jS, Y", strtotime("$miss->create_time"));?></td>
                                        <?php if ($miss->treated == 0): ?>
                                          <td>No</td>
                                        <?php else: ?>
                                          <td>Yes</td>
                                        <?php endif; ?>

                                        <!-- <td><a href="<?=base_url()?>index.php/client/onerequest/<?=$miss->id?>">edit</a> &nbsp -->
                                          <td><a href="<?=base_url()?>index.php/admin/treated/<?=$miss->id?>">Treated</a> &nbsp
                                          <a href="<?=base_url()?>index.php/admin/nottreated/<?=$miss->id?>">Not Treated</a> </td>
                                          <!-- <a href="<?=base_url()?>index.php/client/deleterequest/<?=$miss->id?>">delete</a></td> -->

                                    </tr>
                                  <?php $i++; endforeach; ?>


                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
