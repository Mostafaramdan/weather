<div class="modal fade addEdit-new-modal" id="addEdit-new-modal" tabindex="-1" role="dialog" aria-labelledby="addEdit-new-modal"aria-hidden="true">
    <div class="loading-container"  >
        <div class="spinner-border text-primary" role="status">
        </div>
    </div>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form  id="createUpdate" action="{{route('dashboard.'.Request::segment(2).'.createUpdate')}}" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="id" value="">
                    <div class="form-group">
                        <label for="phones" class="col-form-label"> رقم التليفون :</label>
                        <input type="text"  class="form-control"  name="phones"  data-role="tagsinput">
                    </div>
                    <div class="form-group">
                    <label for="emails" class="col-form-label">الايميل :</label>
                        <input type="text"  class="form-control" name="emails"  data-role="tagsinput">
                    </div>
                    <div class="form-group">
                        <label for="fax" class="col-form-label"> رقم الفاكس :</label>
                        <input type="text"  class="form-control"  name="fax"  data-role="tagsinput">
                    </div>
                    <div class="form-group">
                        <label for="aboutUsAr" class="col-form-label">عن التطبيق  :</label>
                        <textarea type="text" class="form-control" name="aboutUsAr"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="policyAr" class="col-form-label">سياسة الإستخدام :</label>
                        <textarea  type="text" class="form-control" name="policyAr"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="address" class="col-form-label">  العنوان :</label>
                        <input  type="text" class="form-control" name="address">
                    </div>
                    <div class="form-group">
                        <label for="snapshat" class="col-form-label">   ادخل رابط سناب شات   :</label>
                        <input  type="text" class="form-control" name="snapshat">
                    </div>
                    <div class="form-group">
                        <label for="twitter" class="col-form-label">   ادخل رابط تويتر   :</label>
                        <input  type="text" class="form-control" name="twitter">
                    </div>
                    <div class="form-group">
                        <label for="facebook" class="col-form-label">   ادخل رابط فيس بوك   :</label>
                        <input  type="text" class="form-control" name="facebook">
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
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button type="button"  class="btn btn-success submit" id="submit">save</button>
            </div>

        </div>
    </div>
</div>
</div>
