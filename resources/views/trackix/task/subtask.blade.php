<div class="d-flex justify-content-center">
    <div class="spinner-border" style="display:none;" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
<div class="mb-3">
    <div id="taskTabSubtasks">
        @if ($task->subtask->isEmpty())
        <div class="d-flex flex-wrap p-20" id="task-file-list">
            <div class="align-items-center d-flex flex-column text-lightest p-20 w-100">
                <i class="fas fa-list-ul"></i>

                <div class="f-15 mt-4">
                    - No subtask found. -
                </div>
            </div>

        </div>
        @else
        @foreach ($task->subtask as $key => $sub )
        @php
        $is_completed_flag = "";
        $is_completed_flag = $sub->is_completed
        ? "checked"
        : "";
        @endphp
        <div class="row justify-content-between align-items-md-center hover-actions-trigger btn-reveal-trigger border-dashed py-3 gx-0 border-top">
            <div class="col-12">
                <div data-todo-offcanvas-toogle="data-todo-offcanvas-toogle" data-todo-offcanvas-target="todoOffcanvas-1">
                    <div class="form-check mb-1 mb-md-0 d-flex align-items-center lh-1">
                        <input class="form-check-input flex-shrink-0 form-check-line-through mt-0 me-2 form-check-input-undefined" onclick="update_subtask_status(this)" name="subtask-{{$sub->id}}" type="checkbox" id="{{$sub->id}}" {{ $is_completed_flag }}>
                        <label class="form-check-label mb-0 fs-8 me-2 line-clamp-1" for="checkbox-todo-0">{{$sub->title}}</label>
                        <span class="badge badge-phoenix fs-10 ms-auto badge-phoenix-{{$sub->priority->color}}">{{$sub->priority->title}}</span>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="d-flex ms-4 lh-1 align-items-center">
                    <p class="text-body-tertiary fs-10 mb-md-0 me-2 mb-0">{{Carbon\Carbon::parse($sub->create_at)->format('d-M-Y')}}</p>
                    <p class="text-body-tertiary fs-10 fw-bold mb-md-0 mb-0">{{Carbon\Carbon::parse($sub->create_at)->format('h:m:i a')}}</p>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
