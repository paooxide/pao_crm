

    <section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>
                    Selected Events
                    <!-- <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small> -->
                </h2>
            </div>
            <!-- Basic Examples -->
            <!-- #END# Basic Examples -->
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                EXPORTABLE TABLE
                            </h2>

                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                        <div class="body">
                            <div class="table-responsive">
                                <table id="exat" class="table table-bordered table-striped table-hover dataTable js-exportable" >
                                    <thead>
                                        <tr>
                                            <!-- <th>selection</th> -->
                                            <th>Holiday Name</th>
                                            <th>Type</th>
                                            <th>Observers</th>
                                            <th>Date</th>
                                            <!-- <th>End date</th> -->
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                          <!-- <th>selection</th> -->
                                          <th>Holiday Name</th>
                                          <th>Type</th>
                                          <th>Observers</th>
                                          <th>Date</th>
                                          <!-- <th>End date</th> -->
                                        </tr>
                                    </tfoot>

                                    <tbody>



                                      <?php foreach ($holiday as $hol): ?>
                                        <tr>
                                          <!-- <td>
                                            <input type="checkbox" id="<?=$hol->id?>" name="events_list" value="<?=$hol->id?>" unchecked />
                                            <label for="<?=$hol->id?>"></label>
                                          </td> -->
                                          <td><?=$hol->holiday_name?></td>
                                          <td><?=$hol->holiday_type?></td>
                                          <td><?=$hol->celebrant?></td>
                                          <td><?=date("D, M jS, Y", strtotime("$hol->start_date"));?></td>
                                          <!-- <td><?=$hol->end_date?></td> -->
                                        </tr>
                                      <?php endforeach; ?>

                                    </tbody>


                                </table>
                                <div class="col-md-2">
                                  <button class="btn btn-block bg-green waves-effect" id="subevents" type="submit">SUBMIT</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
        </div>
    </section>
