<thead class="thead-dark">
    <tr>
            <th scope="col">العنوان</th>
            <th scope="col">المحتوي</th>
            <th scope="col"><i class="fas fa-eye"></i></th>
            <th scope="col"><i class="fas fa-bell"></i></th>
            <th scope="col">وقت الإنشاء</th>
            <th scope="col">التفعيل</th>
        <th scope="col"></th>
    </tr>
</thead>
<tbody>
@foreach($records as $record)
    <tr class="record-{{$record->id}}" data-id="{{$record->id}}">
        <td>{{Str::words($record->titleAr,4)}}</td>
        <td>{{Str::words($record->contentAr,4)}}</td>
        <td>{{$record->views}}</td>
        <td>{{$record->notify_count}}</td>
        <td>{{Carbon\Carbon::parse($record->createdAt)->toDayDateTimeString()}}</td>
        <td>
            <!-- custom checkbox -->
            <label class="slider-check-box" >
                <input type="checkbox" name="checkbox" @if($record->isActive) checked @endif data-type="isActive">
                <span class="check-box-container d-inline-block" >
                    <span class="circle"></span>
                </span>
            </label>
            <!-- end custom checkbox -->
        </td>
        <td>
          <button class="btn-sm btn btn-danger mb-1"  data-toggle="modal" data-target="#delete-modal"   onClick='deleteRecord("{{$record->id}}")'><i class="fas fa-trash"></i></button>
          <button class="btn-sm btn btn-success edit mb-1" data-toggle="modal" data-target="#addEdit-new-modal"><i class="fas fa-edit"></i></button>
          <button class="btn-sm btn btn-primary get-record mb-1" data-toggle="modal" data-target="#view-modal"><i class="fas fa-eye"></i></button>
        </td>
    </tr>
@endforeach
</tbody>
