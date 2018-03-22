

    <section class="content">
        <div class="container-fluid">


            <!-- Select -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                SEND A FEEDBACK TO CODEC

                            </h2> <br><br>
                            <?php if (isset($message)): ?>
                              <?=$message;?>
                            <?php endif; ?>
                            <?php echo validation_errors(); ?>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                          <form class="" action="<?=base_url()?>index.php/client/makerequest" method="post">
                            <div class="row clearfix">
                                <div class="col-sm-6">
                                    <select class="form-control show-tick" name="mission">
                                        <option value="">-- Message Type --</option>
                                        <option value="enquiry">Enquiry</option>
                                        <option value="complaint">Complaint</option>
                                        <option value="request">Request</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                   <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="subject" placeholder="Subject/Title" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                 <div class="form-group">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="body" placeholder="Enter Message" />
                                        </div>
                                    </div>
                                </div>

                                 <div class="col-sm-6">
                                  <button type="submit" class="btn btn-primary m-t-15 waves-effect">SEND</button>
                                </div>

                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- #END# Select -->
            <!-- Checkbox -->

            <!-- #END# Checkbox -->
        </div>
    </section>
