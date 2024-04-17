<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    <span>零件資料</span>
                    <span id='copy_pn'></span>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body table-responsive">
                <table id='table_mpi' class="table text-nowrap">
                    <thead>
                        <tr>
                            <th scope="col">零件編碼</th>
                            <th scope="col">車種</th>
                            <th scope="col">系類</th>
                            <th scope="col">項目</th>
                            <th scope="col">料一</th>
                            <th scope="col">料二</th>
                            <th scope="col">零件</th>
                            <th scope="col">規格</th>
                            <th scope="col">單位</th>
                            <th scope="col">單價</th>
                            <th scope="col">零件&規格</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>零件編碼</th>
                            <th>車種</th>
                            <th>系類</th>
                            <th>項目</th>
                            <th>料一</th>
                            <th>料二</th>
                            <th>零件</th>
                            <th>規格</th>
                            <th>單位</th>
                            <th>單價</th>
                            <th>零件&規格</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> --}}
        </div>
    </div>
</div>

<script>
    $('#table_mpi').DataTable({
        // "dom": 'lrtip',
        "ajax": {
            "url": "{!! Route('m_part_information') !!}",
            "method": "GET",
            "dataType": "json",
            "dataSrc": "table_mpi",
            "data": function(d) { //submit資料
                // d.recruit_number = recruit_number;
            },
        },
        "columnDefs": [{
            targets: ["nosort"], //設定 class='nosort'
            visible: false,
            searchable: false,
        }],
        "columns": [{
                "data": "part_id"
            },
            {
                "data": "v_type"
            },
            {
                "data": "s_department"
            },
            {
                "data": "s_project"
            },
            {
                "data": "s_materials1"
            },
            {
                "data": "s_materials2"
            },
            {
                "data": "s_name"
            },
            {
                "data": "s_specification"
            },
            {
                "data": "s_unit"
            },
            {
                "data": "s_money"
            },
            {
                "data": "s_name_specification"
            },
        ],
        initComplete: function() {
            var api = this.api(); //
            $(api.table().footer()).find('th').each(function() {
                var title = $(this).text();
                $(this).html(
                    '<input type="text" class="form-control form-control-sm" placeholder="' +
                    title + '" />');
            });

            $(api.table().footer()).find('input').on('keyup change', function() {
                var index = $(this).parent().index();
                api.column(index).search(this.value).draw();
            });
            $(".sorting_1").on('click', function() {
                var textToCopy = $(this).text();
                navigator.clipboard.writeText(textToCopy).then(function() {
                    $("#copy_pn").html("(已複製"+textToCopy+")")
                }).catch(function(err) {
                    $("#copy_pn").html()
                });
            });

        },
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/zh-HANT.json',
        },
        stateSave: true,
    });
</script>
