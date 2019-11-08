<div class="col-md-4">
    <div class="card">
        <div class="card-body">
            <div class="d-flex no-block align-items-center">
                <div>
                    <h5 class="card-title m-b-0">TO DO LIST</h5>
                </div>
                <div class="ml-auto">
                    <button class="pull-right btn btn-circle btn-success" data-toggle="modal" data-target="#myModal"><i class="ti-plus"></i></button>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- To do list widgets -->
            <!-- ============================================================== -->
            <div class="to-do-widget m-t-20" id="todo" style="height: 400px;position: relative;">
                <!-- .modal for add task -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Add Task</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                            </div>
                            <div class="modal-body">
                                <form>
                                    <div class="form-group">
                                        <label>Task name</label>
                                        <input type="text" class="form-control" placeholder="Enter Task Name"> </div>
                                    <div class="form-group">
                                        <label>Assign to</label>
                                        <select class="custom-select form-control pull-right">
                                            <option selected="">Sachin</option>
                                            <option value="1">Sehwag</option>
                                            <option value="2">Pritam</option>
                                            <option value="3">Alia</option>
                                            <option value="4">Varun</option>
                                        </select>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-success" data-dismiss="modal">Submit</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
                <ul class="list-task todo-list list-group m-b-0" data-role="tasklist">
                    <li class="list-group-item" data-role="task">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck">
                            <label class="custom-control-label" for="customCheck">
                                <span>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been</span> <span class="badge badge-pill badge-danger float-right">Today</span>
                            </label>
                        </div>
                        <ul class="assignedto">
                            <li><img src="{{asset('Axton/assets/img')}}/users/1.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Steave"></li>
                            <li><img src="{{asset('Axton/assets/img')}}/users/2.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Jessica"></li>
                            <li><img src="{{asset('Axton/assets/img')}}/users/3.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Priyanka"></li>
                            <li><img src="{{asset('Axton/assets/img')}}/users/4.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Selina"></li>
                        </ul>
                    </li>
                    <li class="list-group-item" data-role="task">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">
                                <span>Lorem Ipsum is simply dummy text of the printing</span><span class="badge badge-pill badge-primary float-right">1 week </span>
                            </label>
                        </div>
                        <div class="item-date"> 26 jun 2017</div>
                    </li>
                    <li class="list-group-item" data-role="task">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                            <label class="custom-control-label" for="customCheck2">
                                <span>Give Purchase report to</span> <span class="badge badge-pill badge-info float-right">Yesterday</span>
                            </label>
                        </div>
                        <ul class="assignedto">
                            <li><img src="{{asset('Axton/assets/img')}}/users/3.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Priyanka"></li>
                            <li><img src="{{asset('Axton/assets/img')}}/users/4.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Selina"></li>
                        </ul>
                    </li>
                    <li class="list-group-item" data-role="task">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck3">
                            <label class="custom-control-label" for="customCheck3">
                                <span>Lorem Ipsum is simply dummy text of the printing </span> <span class="badge badge-pill badge-warning float-right">2 weeks</span>
                            </label>
                        </div>
                        <div class="item-date"> 26 jun 2017</div>
                    </li>
                    <li class="list-group-item" data-role="task">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck4">
                            <label class="custom-control-label" for="customCheck4">
                                <span>Give Purchase report to</span> <span class="badge badge-pill badge-info float-right">Yesterday</span>
                            </label>
                        </div>
                        <ul class="assignedto">
                            <li><img src="{{asset('Axton/assets/img')}}/users/3.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Priyanka"></li>
                            <li><img src="{{asset('Axton/assets/img')}}/users/4.jpg" alt="user" data-toggle="tooltip" data-placement="top" title="" data-original-title="Selina"></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
