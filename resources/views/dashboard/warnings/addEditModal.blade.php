<div class="modal fade addEdit-new-modal" id="addEdit-new-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
    <div class="loading-container"  >
      <div class="spinner-border text-primary" role="status">
      </div>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="createUpdate" action="{{route('dashboard.'.Request::segment(2).'.createUpdate')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="">
                    <div class="form-group contentAr-ckEditor">
                        <label for="contentAr" class="col-form-label">ادخل محتوي التحذير :</label>
                        @include('dashboard.layouts.ckEditor',['field'=>'contentAr'])
                    </div>
                    <div class="form-group ">
                        <label for="startDate" class="col-form-label">ادخل تاريخ البدابة :</label>
                        <input type="date" class="form-control" name="startDate">
                    </div>
                    <div class="form-group ">
                        <label for="endDate" class="col-form-label">ادخل تاريخ النهاية :</label>
                        <input type="date" class="form-control" name="endDate">
                    </div>
                    <div class="row mr-10" >
                        <div class="form-group">
                            <div class="form-check">
                                <label class="form-check-label " for="flexCheckIndeterminate">
                                    إرسال اشعار للمستخدمين ؟
                                  </label>
                                <input class="form-check-input m-1" style="width: 19px; height: 18px;"type="checkbox" value="on" id="flexCheckIndeterminate" name="sendNotification">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" >
                        <div class="progress " >
                            <div class="progress-bar"  role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">0%</div>
                        </div>
                    </div>
                </form>
                <div class="alert " >
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">الغاء</button>
                <button type="button"  class="btn btn-success submit" id="submit">حفظ</button>
            </div>

        </div>
    </div>
</div>
</div>
