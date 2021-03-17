@php
    $pageResource = 'admin.brands';
@endphp

<x-admin::layout.resource.index pageTitle="Brands" :pageResource="$pageResource" :records="$records" activeNavSelector="#brands-sm .nav-link" activeNavParentSelector="#settings-mm.nav-item">
    <x-slot name="filter"></x-slot>

    <thead>
    <tr>
        <th>SL.</th>
        <th>Code</th>
        <th>Title</th>
        <th>Created at</th>
        <th class="text-center not-export-col">Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($records as $key => $record)
        <tr>
            <td>{{$serial++}}</td>
            <td>{{$record->code}}</td>
            <td>{{$record->title}}</td>
            <td>{{formatDateTime($record->created_at)}}</td>
            <td class="text-center">
                @php
                    $access = 1;
                    listAction([
                        actionLi(route($pageResource.'.show', $record->id), 'show', $access),
                        actionLi(route($pageResource.'.edit', $record->id), 'edit', $access),
                        actionLi(route($pageResource.'.destroy', $record->id), 'delete', $access),
                    ]);
                @endphp
            </td>
        </tr>
    @endforeach
    </tbody>

    <x-slot name="scripts">
        <script>
            function editCategory(id) {
                ;
            }

            window.addEventListener('showAddModal', evt => {
                $('#add-modal').modal('show');
            })
            window.addEventListener('hideAddModal', evt => {
                $('#add-modal').modal('hide');
                window.location.reload();
            })
            window.addEventListener('showEditModal', evt => {
                $('#edit-modal').modal('show');
            })
            window.addEventListener('hideEditModal', evt => {
                $('#edit-modal').modal('hide');
                window.location.reload();
            })
        </script>
    </x-slot>
</x-admin::layout.resource.index>
