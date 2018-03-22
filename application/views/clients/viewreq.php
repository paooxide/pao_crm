

    <section class="content">
        <div class="container-fluid">


            <!-- Select -->

            <!-- #END# Select -->
            <!-- Checkbox -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                REQUEST LOG
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
                                        <td><a href="<?=base_url()?>index.php/client/onerequest/<?=$miss->id?>">edit</a> &nbsp
                                          <a href="<?=base_url()?>index.php/client/onerequest/<?=$miss->id?>">view</a> &nbsp
                                          <a href="<?=base_url()?>index.php/client/deleterequest/<?=$miss->id?>">delete</a></td>

                                    </tr>
                                  <?php $i++; endforeach; ?>


                                </tbody>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Checkbox -->
        </div>
    </section>
