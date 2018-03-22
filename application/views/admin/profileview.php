
    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix">

                <!-- Profile Info -->
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <div class="card">
                        <div class="header">
                            <h2>PROFILE DETAILS</h2>

                        </div>
                        <?php if (isset($message)): ?>
                          <?=$message;?>
                        <?php endif; ?>

                        <?php echo validation_errors(); ?>
                        <form class="" action="<?=base_url()?>index.php/client/createprofile" method="post">

                        <div class="body">
                             <div class="row clearfix">
                                 <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="first_name" value="<?=$profile->first_name?>"disabled>
                                            <label class="form-label">First Name</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="last_name" value="<?=$profile->last_name?>" disabled>
                                            <label class="form-label">Last Name</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="phone" value="<?=$profile->phone?>"disabled>
                                            <label class="form-label">Mobile Number</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="company" value="<?=$profile->company?>"disabled>
                                            <label class="form-label">Company</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" class="form-control" name="address" value="<?=$profile->address?>" disabled>
                                            <label class="form-label">Residential Address</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <!-- <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE</button> -->
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- #END# Profile Info -->

            </div>
        </div>
    </section>
