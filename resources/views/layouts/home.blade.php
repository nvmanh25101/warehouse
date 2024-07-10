@extends('layouts.master')
@push('css')

@endpush
@section('content')
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <blockquote class="card-bodyquote text-lg">
                    <p>Công ty TNHH truyền thông và công nghệ 3i được sáng lập với lý tưởng vận dụng sức sáng tạo của
                        con người về măt công nghệ để phục vụ xã hội những sản phẩm và giải pháp mang tính trí tuệ và
                        hiệu quả cao trong cuộc sống.
                        Được thành lâp vào tháng 3 năm 2006 với tiền thân là một đội chuyên gia phần mềm và giải pháp
                        viễn thông có kinh nghiệm từ Hàn Quốc. Chúng tôi đang từng bước đạt được uy tín và niềm tin từ
                        khách hàng với những sản phẩm công nghệ hiện đại và phù hợp với các doanh nghiệp trong nước và
                        các đối tác nước ngoài như Hàn Quốc, Nhật Bản, Trung Quốc.
                    </p>
                    <p>
                        Hệ thống sản phẩm của 3i hiện nay chủ yếu về các lĩnh vực internet , truyền thông , các giải
                        pháp tối ưu hóa quy trình quản lý kho trong các doanh nghiệp như sản xuất , kinh doanh. Ngoài ra
                        để đáp ứng nhu cầu ngày càng cao của thị trường, 3i cũng cung cấp đội ngũ nhân lực dày kinh
                        nghiệm và năng động cho các công ty outsource và nhận gia công các sản phẩm thương mại điện tử,
                        ứng dụng thông minh, hệ thống website bản hàng..vv.
                    </p>
                </blockquote>
            </div> <!-- end card-body-->
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('storage/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('storage/notify.min.js') }}"></script>
    <script type="text/javascript">
        @if(session('success'))
        $.notify('{{ session('success') }}', "success");
        @endif
        @if(session('error'))
        $.notify('{{ session('error') }}', "error");
        @endif
    </script>
@endpush
