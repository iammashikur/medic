<?php

namespace App\DataTables;

use App\Models\Compounder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CompounderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('image', function($image){

                $url=asset("/uploads/images/$image->avatar");
                return '<img src='.$url.' border="0" width="100" class="img-rounded" align="center" />';


            })

            ->addColumn('action', function($action){
                return '<a class="btn-sm btn-primary" href="'.route('compounder.edit', $action->id).'"><i class="far fa-edit"></i></a>
                        <a class="btn-sm btn-danger delete" href="'.route('compounder.destroy', $action->id).'"><i class="far fa-trash-alt"></i></a>';
            })

           ->rawColumns(['image', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Compounder $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Compounder $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
                    ->setTableId('compounder-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),

                        Button::make('reset'),

                    );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [

            Column::make('id'),
            Column::make('image'),
            Column::make('name'),
            Column::make('phone'),

            Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(100)
            ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Compounder_' . date('YmdHis');
    }
}
