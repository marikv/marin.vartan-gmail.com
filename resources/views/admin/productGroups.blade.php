@extends('admin.layout')

@section('content')


    <h1>Продукты</h1>

    <form method="get" id="searchForm" action="">
        <div class="row mb-5">
            <div class="col-4">
                <div class="form-group">
                    <label for="name">Бренд</label>
                    <select onchange="this.form.submit()" class="form-control" name="brand_id_search" id="brand_id_search">
                        <option value="">Все</option>
                        @foreach ($brands as $row)
                            <option
                                @if($brand_id_search==$row['id'])
                                    selected="selected"
                                @endif
                                value="{{ $row['id'] }}"
                            >{{ $row['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4">

            </div>
            <div class="col-4">
                <button class="btn btn-success float-right" type="button" data-toggle="modal" data-target=".itemModal">Добавить
                </button>
            </div>
        </div>
    </form>

    <div class="modal fade itemModal " tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel123"
         aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content  bg-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Продукт</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="itemForm" enctype="multipart/form-data" action="/adm/addOrSaveProductGroup">
                        <input type="hidden" id="id" name="id" value="0"/>
                        <div class="row">
                            <div class="col-8">
                                <div class="form-group">
                                    <label for="photo">изображение записи</label>
                                    <div>
                                        <img id="photo_img" src="/uploads/no-image.png" style="height: 90px;"/>
                                        <input type="file" name="photo" id="photo" placeholder=""/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">

                                    <label for="name">На главную страницу (HomePage)</label>
                                    <select class="form-control" name="show_on_homepage" id="show_on_homepage">
                                            <option value="0">Нет</option>
                                            <option value="1">Да</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Бренд</label>
                            <select class="form-control" name="brand_id" id="brand_id">
                                @foreach ($brands as $row)
                                    <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="name">Наименование</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="name">Краткое описание</label>
                            <textarea class="form-control" name="mini_description" id="mini_description"
                                      rows="2"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description">Описание</label>
                            <textarea class="form-control my-wysiwyg" id="description" rows="3"></textarea>
                        </div>
                        <h3>SEO</h3>
                        <div class="form-group">
                            <label for="name">META Title</label>
                            <input type="text" class="form-control" name="meta_title" id="meta_title">
                        </div>
                        <div class="form-group">
                            <label for="name">META keywords</label>
                            <textarea class="form-control" name="meta_keywords" id="meta_keywords" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="name">META description</label>
                            <textarea class="form-control" name="meta_description" id="meta_description"
                                      rows="3"></textarea>
                        </div>
                        <h3>Settings</h3>
                        <div class="form-group">
                            <label for="name">Сортировка (sort_by)</label>
                            <input type="text" class="form-control" name="order_by" id="order_by">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <span id="result"></span>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" data-dismiss="modal" id="btnSubmit" class="btn btn-primary"
                            onclick="ajaxSubmitForm('itemForm')">Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>


    <table id="loadTable" class="table table-bordered bg-light table-hover">
        <thead>
        <tr>
            <th scope="col" data-col="id" style="width: 50px;">id</th>
            <th scope="col" data-col="photo" style="width: 200px;">фото</th>
            <th scope="col" data-col="name">Наименование</th>
            <th scope="col" data-col="mini_description">Краткое описание</th>
            <th scope="col" data-col="show_on_homepage" style="width: 130px;">На глав. стр.</th>
            <th scope="col" data-col="order_by" style="width: 50px;">Сорт.</th>
            <th scope="col" data-col="actions" style="width: 150px;"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tableData['data'] as $row)

            <tr id="trItem{{ $row['id'] }}">
                <td>{{ $row['id'] }}</td>
                <td><img src="{{ $row['photo'] ?: 'no-image.png' }}" style="height: 70px;"/></td>
                <td>{{ $row['name'] }}</td>
                <td>{{ $row['mini_description'] }}</td>
                <td>{{ ($row['show_on_homepage'] ? 'Да' : '') }}</td>
                <td>{{ $row['order_by'] }}</td>
                <td>
                    <button class="btn btn-success" onclick="editItem({{json_encode($row)}})">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button class="btn btn-danger" onclick="deleteItem('ProductGroup', {{ $row['id'] }})"><i
                            class="far fa-trash-alt"></i></button>
                </td>
            </tr>

        @endforeach
        </tbody>
    </table>
    {!! $tablePagination !!}
@endsection
