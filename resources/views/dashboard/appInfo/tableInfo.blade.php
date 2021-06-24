<thead class="thead-dark">
<tr>
<th scope="col"> </th>
<th scope="col"># </th>
</tr>
</thead>
<tbody>
    <tr >
        <td> التليفون</td>
        <td> @foreach ($record->phones as $phone) {{$phone->phone}} -  @endforeach</td>
    </tr>
    <tr >
        <td>الايميل</td>
        <td> @foreach ($record->emails as $email) {{$email->email}} - @endforeach</td>

    </tr>
    <tr >
        <td> فاكس </td>
        <td>{{$record->fax}}</td>
    </tr>
    <tr >
        <td> عن التطبيق </td>
        <td>{{$record->aboutUsAr}}</td>
    </tr>

    <tr >
        <td>  سياسة الإستخدام </td>
        <td>{{$record->policyAr}}</td>
    </tr>
    <tr >
        <td>   العنوان </td>
        <td>{{$record->address}}</td>
    </tr>
    <tr >
        <td>  رابط سناب شات   </td>
        <td>{{$record->snapshat}}</td>
    </tr>
    <tr >
        <td>  رابط  تويتر   </td>
        <td>{{$record->twitter}}</td>
    </tr>
    <tr >
        <td>  سياسة فيس بوك </td>
        <td>{{$record->facebook}}</td>
    </tr>
</tbody>
