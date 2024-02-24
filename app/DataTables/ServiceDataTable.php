<?php

namespace App\DataTables;

use App\Models\Service;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use Yajra\DataTables\Html\Builder;
use Yajra\DataTables\DataTableAbstract;

class ServiceDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($service) {
                $actionHtml = '<div class="d-flex align-items-center gap-3">';
                $actionHtml .= '<a href="#" class="text-decoration-none" data-toggle="modal" data-target="#viewModal' . $service->id . '"><i class="fa-solid fa-eye"></i>View</a>';

                if (auth()->check()) {
                    $user = auth()->user();

                    if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                        $actionHtml .= '
                        <div class="dropdown dropright">
                            <a href="#" class="text-decoration-none dropdown-toggle"
                                data-toggle="dropdown" aria-expanded="false">
                                More
                            </a>
                            <div class="dropdown-menu">';

                        if ($user->hasRole('superadmin') || $user->hasRole('jeffri') || $user->hasRole('maulana')) {
                            $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-target="#copyText' . $service->id . '"><i
                                                class="fa-solid fa-clone"></i> Copy</a>';
                        }
                        if ($user->hasRole('superadmin') || $user->hasRole('jeffri')) {
                            $actionHtml .= '<a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-target="#editModal' . $service->id . '"><i
                                                class="fa-solid fa-pen-to-square"></i> Edit</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-target="#deleteModal' . $service->id . '"><i
                                                class="fa-solid fa-trash"></i> Delete</a>';
                        }

                        $actionHtml .= '</div>
                        </div>';
                    }
                }

                $actionHtml .= '</div>';
                return $actionHtml;
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }


    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Service $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Service $model): QueryBuilder
    {
        return $model->newQuery()->where('status', 'selesai')->where('pemilik', 'stock')->orderBy('tanggalkeluar', 'desc');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('service-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('row_number')
            ->title('No')
            ->render('meta.row + meta.settings._iDisplayStart + 1;')
            ->width(50)
            ->orderable(false),
            Column::make('serialnumber'),
            Column::make('pelanggan'),
            Column::make('device'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Service_' . date('YmdHis');
    }
}
