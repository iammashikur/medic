<?php

namespace App\DataTables;

use App\Models\TestCategory;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TestCategoriesDataTable extends DataTable
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
            ->addColumn('action', function($action){
                return '<a class="btn-sm btn-primary" href="'.route('test-category.edit', $action->id).'"><i class="far fa-edit"></i></a>
                        <a class="btn-sm btn-danger delete" href="'.route('test-category.destroy', $action->id).'"><i class="far fa-trash-alt"></i></a>';
            })

            ->addColumn('image', function($image){

                $url=asset("/uploads/images/$image->image");
                return '<img src='.$url.' border="0" width="100" class="img-rounded" align="center" />';


            })

           ->rawColumns(['action','image']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\TestCategory $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(TestCategory $model)
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
                    ->setTableId('testcategories-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
                    ->buttons(
                        Button::make('create'),

                        Button::make('reload')
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
            Column::make('name'),
            Column::make('image'),
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
        return 'TestCategories_' . date('YmdHis');
    }
}
