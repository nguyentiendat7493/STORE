<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label">Tên gợi nhớ</label>
        <input class="form-control" name="label" value="{{ old('label', $address?->label ?? 'Nhà riêng') }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Tên người nhận</label>
        <input class="form-control" name="recipient_name" value="{{ old('recipient_name', $address?->recipient_name ?? auth()->user()->name) }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Số điện thoại</label>
        <input class="form-control" name="phone" value="{{ old('phone', $address?->phone ?? auth()->user()->phone) }}" required>
    </div>
    <div class="col-md-6">
        <label class="form-label">Tỉnh/Thành phố</label>
        <input class="form-control" name="city" value="{{ old('city', $address?->city ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Quận/Huyện</label>
        <input class="form-control" name="district" value="{{ old('district', $address?->district ?? '') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Phường/Xã</label>
        <input class="form-control" name="ward" value="{{ old('ward', $address?->ward ?? '') }}">
    </div>
    <div class="col-12">
        <label class="form-label">Địa chỉ cụ thể</label>
        <textarea class="form-control" name="address_line" rows="3" required>{{ old('address_line', $address?->address_line ?? '') }}</textarea>
    </div>
    <div class="col-md-6">
        <label class="form-label">Quốc gia</label>
        <input class="form-control" name="country" value="{{ old('country', $address?->country ?? 'Việt Nam') }}">
    </div>
    <div class="col-md-6">
        <label class="form-label">Mã bưu chính</label>
        <input class="form-control" name="postal_code" value="{{ old('postal_code', $address?->postal_code ?? '') }}">
    </div>
    <div class="col-12">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_default" value="1" @checked(old('is_default', $address?->is_default ?? false))>
            <label class="form-check-label">Dùng làm địa chỉ mặc định</label>
        </div>
    </div>
</div>
