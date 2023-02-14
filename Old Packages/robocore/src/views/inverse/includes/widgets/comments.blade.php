

<div class="row">
    <!-- ============================================================== -->
    <!-- Comment widgets -->
    <!-- ============================================================== -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Recent Comments</h5>
            </div>
            <!-- ============================================================== -->
            <!-- Comment widgets -->
            <!-- ============================================================== -->
            <div class="comment-widgets" id="comment" style="height: 630px;position: relative;">
                <!-- Comment Row -->

               @foreach($comments as $item)

                <div class="d-flex no-block comment-row">
                    <div class="p-2"><span class="round"><img src="{{asset('Axton/assets/img')}}/users/{{$item->user->avatar}}.jpg" alt="user" width="50"></span></div>
                    <div class="comment-text w-100">
                        <h5 class="font-medium">{{$item->user->name}}</h5>
                        <p class="m-b-10 text-muted">{{$item->comment}}</p>
                        <div class="comment-footer">
                            <span class="text-muted pull-right">{{$item->updated_at}}</span>
                            <span class="badge badge-pill {{$item->status->style}}">{{$item->status->name}}</span> <span class="action-icons">
                                <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                <a href="javascript:void(0)"><i class="ti-check"></i></a>
                                <a href="javascript:void(0)"><i class="ti-heart"></i></a>
                            </span>
                        </div>
                    </div>
                </div>

                @endforeach

            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Table -->
    <!-- ============================================================== -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex">
                    <div>
                        <h5 class="card-title">Sales Overview</h5>
                        <h6 class="card-subtitle">Check the monthly sales </h6>
                    </div>
                    <div class="ml-auto">
                        <select class="form-control b-0">
                            <option>January</option>
                            <option value="1">February</option>
                            <option value="2" selected="">March</option>
                            <option value="3">April</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-body bg-light">
                <div class="row">
                    <div class="col-6">
                        <h3>March 2017</h3>
                        <h5 class="font-light m-t-0">Report for this month</h5></div>
                    <div class="col-6 align-self-center display-6 text-right">
                        <h2 class="text-success">$3,690</h2></div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover no-wrap">
                    <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>NAME</th>
                        <th>STATUS</th>
                        <th>DATE</th>
                        <th>PRICE</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td class="text-center">1</td>
                        <td class="txt-oflo">Elite admin</td>
                        <td><span class="badge badge-success badge-pill">sale</span> </td>
                        <td class="txt-oflo">April 18, 2017</td>
                        <td><span class="text-success">$24</span></td>
                    </tr>
                    <tr>
                        <td class="text-center">2</td>
                        <td class="txt-oflo">Real Homes</td>
                        <td><span class="badge badge-info badge-pill">extended</span></td>
                        <td class="txt-oflo">April 19, 2017</td>
                        <td><span class="text-info">$1250</span></td>
                    </tr>
                    <tr>
                        <td class="text-center">3</td>
                        <td class="txt-oflo">Ample Admin</td>
                        <td><span class="badge badge-info badge-pill">extended</span></td>
                        <td class="txt-oflo">April 19, 2017</td>
                        <td><span class="text-info">$1250</span></td>
                    </tr>
                    <tr>
                        <td class="text-center">4</td>
                        <td class="txt-oflo">Medical Pro</td>
                        <td><span class="badge badge-danger badge-pill">tax</span></td>
                        <td class="txt-oflo">April 20, 2017</td>
                        <td><span class="text-danger">-$24</span></td>
                    </tr>
                    <tr>
                        <td class="text-center">5</td>
                        <td class="txt-oflo">Hosting press html</td>
                        <td><span class="badge badge-success badge-pill">sale</span></td>
                        <td class="txt-oflo">April 21, 2017</td>
                        <td><span class="text-success">$24</span></td>
                    </tr>
                    <tr>
                        <td class="text-center">6</td>
                        <td class="txt-oflo">Digital Agency PSD</td>
                        <td><span class="badge badge-success badge-pill">sale</span> </td>
                        <td class="txt-oflo">April 23, 2017</td>
                        <td><span class="text-danger">-$14</span></td>
                    </tr>
                    <tr>
                        <td class="text-center">7</td>
                        <td class="txt-oflo">Helping Hands</td>
                        <td><span class="badge badge-warning badge-pill">member</span></td>
                        <td class="txt-oflo">April 22, 2017</td>
                        <td><span class="text-success">$64</span></td>
                    </tr>
                    <tr>
                        <td class="text-center">8</td>
                        <td class="txt-oflo">Ample Admin</td>
                        <td><span class="badge badge-info badge-pill">extended</span></td>
                        <td class="txt-oflo">April 19, 2017</td>
                        <td><span class="text-info">$1250</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

