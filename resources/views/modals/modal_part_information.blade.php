<!-- Modal -->
<div class="modal fade" id="partInformationModal" tabindex="-1" aria-labelledby="partInformationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="partInformationModalLabel">
                    <span>零件資料</span>
                    <span id='copy_pn'></span>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body table-responsive">
                <table id='table_mpi' class="table text-nowrap">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">零件編碼</th>
                            <th scope="col">車種</th>
                            <th scope="col">系類</th>
                            <th scope="col">項目</th>
                            <th scope="col">料一</th>
                            <th scope="col">料二</th>
                            <th scope="col">零件</th>
                            <th scope="col">規格</th>
                            <th scope="col">單位</th>
                            <th scope="col">單價(97%)</th>
                            <th scope="col">單價(90%)</th>
                            <th scope="col">零件&規格</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>零件編碼</th>
                            <th>車種</th>
                            <th>系類</th>
                            <th>項目</th>
                            <th>料一</th>
                            <th>料二</th>
                            <th>零件</th>
                            <th>規格</th>
                            <th>單位</th>
                            <th>單價(97%)</th>
                            <th>單價(90%)</th>
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
    //增加明細清單 (零件編碼)
    $(document).on('click', '.in_part_id', function() {
        // var textToCopy = $(this).text();
        var partid = $(this).data('partid');
        var in_type = '1'; //有資料，插入細項清單上方
        var part_type = 'part'; //零件類型
        $("#copy_pn").html("(已添加" + partid + ")")
        
        tr_wo_detail_add(in_type, partid, part_type)
    });
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
            "data": "in_part_id"
            }, {
                "data": "part_id"
            }, {
                "data": "v_type"
            }, {
                "data": "s_department"
            }, {
                "data": "s_project"
            }, {
                "data": "s_materials1"
            }, {
                "data": "s_materials2"
            }, {
                "data": "s_name"
            }, {
                "data": "s_specification"
            }, {
                "data": "s_unit"
            }, {
                "data": "s_money_97"
            }, {
                "data": "s_money_90"
            }, {
                "data": "s_name_specification"
        }, ],
        initComplete: function() {
            var api = this.api(); //
            $(api.table().footer()).find('th').each(function(index) {
                if (index === 0)  return;
                var title = $(this).text();
                $(this).html(
                    '<input type="text" class="form-control form-control-sm" placeholder="' +
                    title + '" />');
            });

            $(api.table().footer()).find('input').on('keyup change', function() {
                var index = $(this).parent().index();
                api.column(index).search(this.value).draw();
            });
        },
        "language": {
            url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/zh-HANT.json',
        },
        "stateSave": true,
        "pageLength": 8, // 預設每頁顯示
        "lengthMenu": [8, 16, 32, 64], // 可選擇的每頁顯示
    });
</script>
