@extends('admin.layout.layout')

@section('title', 'Dashboard')
@section('mainContent')
  <div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Websites</h4>
            <a class="btn btn-primary btn-block cur-p" href="{{route('websites.create')}}" style="display: inline-block; width: auto;  margin-bottom:10px;">Add New Website</a>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Website</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($websites as $website): ?>
                <tr>
                    <th scope="row"><?php echo $website->url; ?></th>
                    <td>
                      <div class="row">
                        <div class="col-md-6">
                          <a href="{{route('websites.showPixel', ['website' => $website])}}" class="btn btn-outline-secondary btn-block">Show Pixel</a>
                        </div>
                        <div class="col-md-6">
                          <a href="{{route('websites.show', ['website' => $website])}}" class="btn btn-outline-info btn-block">Analytics</a>
                        </div>
                      </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <?php echo $websites->render(); ?>
        </div>
    </div>
  </div>
@endsection
