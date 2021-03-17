<x-admin::layout.resource.show pageTitle="Brands" pageResource="admin.brands" :data="$data">
    <tr>
        <th style="width:230px;">Title</th>
        <th style="width:10px;">:</th>
        <td>{{$data->title}}</td>
    </tr>
    <tr>
        <th>Code</th>
        <th>:</th>
        <td>{{ $data->code }}</td>
    </tr>
    <tr>
        <th>Slug</th>
        <th>:</th>
        <td>{{ $data->slug }}</td>
    </tr>
    <tr>
        <th>Description</th>
        <th>:</th>
        <td>{{ $data->description }}</td>
    </tr>
    <tr>
        <th>Created At</th>
        <th>:</th>
        <td>{{ $data->created_at }}</td>
    </tr>
</x-admin::layout.resource.show>
