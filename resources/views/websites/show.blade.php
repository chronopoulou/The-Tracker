@extends('admin.layout.layout')

@section('title', 'Dashboard')
@section('mainContent')
  <div class="row">
    <div class="masonry-item col-md-12">
            <!-- #Sales Report ==================== -->
            <div class="bd bgc-white">
                <div class="layers">

                    <div class="layer w-100">
                        <div class="bgc-light-blue-500 c-white p-20">
                            <div class="peers ai-c jc-sb gap-40">
                                <div class="peer peer-greed">
                                    <h5>{{$website->url}}</h5>
                                    <p class="mB-0">Visits</p>
                                </div>
                                <div class="peer">
                                    <h3 class="text-right">{{$website->visitors->count()}}</h3>
                                    <p class="mB-0">Visitors</p>
                                </div>

                                <div class="peer">
                                    <h3 class="text-right">{{$website->actions->count()}}</h3>
                                    <p class="mB-0">Visits</p>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive p-20">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class=" bdwT-0">Visitor</th>
                                    <th class=" bdwT-0">URL</th>
                                    <th class=" bdwT-0">Browser</th>
                                    <th class=" bdwT-0">IP</th>
                                    <th class=" bdwT-0">Date</th>
                                    <th class=" bdwT-0">First Visit</th>

                                </tr>
                                </thead>
                                <tbody>

                                <?php foreach ($visits as $visit): ?>
                                <tr>
                                    <td class="fw-600">#{{$visit->visitor_id}}</td>
                                    <td>
                                        {{$visit->url}} <a href="{{$visit->url}}"><i class="ti ti-new-window"></i></a>
                                    </td>
                                    <td>
                                      <span class="badge bgc-blue-50 c-blue-700 p-10 lh-0 tt-c badge-pill">{{$visit->browser}}</span>
                                    </td>
                                    <td><span class="text-success">{{$visit->ip}}</span></td>
                                    <td>{{Carbon\Carbon::parse($visit->created_at)->diffForHumans()}}</td>
                                    <td>{{Carbon\Carbon::parse($visit->visitor->created_at)->diffForHumans()}}</td>
                                </tr>
                                <?php endforeach; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="ta-c bdT w-100 p-20">
                <?php echo $visits->render(); ?>
                </div>
            </div>
        </div>

  </div>
@endsection
