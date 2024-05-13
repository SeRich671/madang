<template>
  <div class="col-lg-12">
    <div class="bg-white p-3">
      <div class="row mb-4">
        <label for="address_id" class="col-lg-4 col-form-label text-lg-end">Książka adresowa</label>

        <div class="col-lg-4">
          <select class="form-control @error('address_id') is-invalid @enderror" name="address_id" value="{{ old('address_id') }}">
            <option value="0" selected>--wybierz--</option>
            @foreach($addresses as $address)
            <option value="{{ $address->id }}">
              {{ $address->city }}, {{ $address->street }}, {{ $address->zip_code }}
            </option>
            @endforeach
          </select>

          @error('address_id')
          <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
          @enderror
        </div>
      </div>
      <div class="row mt-4 mb-3">
        <label for="first_name" class="col-lg-4 col-form-label text-lg-end">Imię</label>

        <div class="col-lg-4">
          <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name">

          @error('first_name')
          <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
          @enderror
        </div>
      </div>
      <div class="row mb-3">
        <label for="last_name" class="col-lg-4 col-form-label text-lg-end">Nazwisko</label>

        <div class="col-lg-4">
          <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">

          @error('last_name')
          <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
          @enderror
        </div>
      </div>
      <div class="row mb-3">
        <label for="company_name" class="col-lg-4 col-form-label text-lg-end">Firma <small>(opcjonalne)</small></label>

        <div class="col-lg-4">
          <input id="company_name" type="text" class="form-control @error('company_name') is-invalid @enderror" name="company_name" value="{{ old('company_name') }}" required autocomplete="company_name">

          @error('company_name')
          <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
          @enderror
        </div>
      </div>
      <div class="row mb-3">
        <label for="address" class="col-lg-4 col-form-label text-lg-end">Adres</label>

        <div class="col-lg-4">
          <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">

          @error('address')
          <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
          @enderror
        </div>
      </div>
      <div class="row mb-3">
        <label for="city" class="col-lg-4 col-form-label text-lg-end">Miasto</label>

        <div class="col-lg-4">
          <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="city">

          @error('city')
          <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
          @enderror
        </div>
      </div>
      <div class="row mb-3">
        <label for="zipcode" class="col-lg-4 col-form-label text-lg-end">Kod pocztowy</label>

        <div class="col-lg-4">
          <input id="zipcode" type="text" class="form-control @error('zipcode') is-invalid @enderror" name="zipcode" value="{{ old('zipcode') }}" required autocomplete="zipcode">

          @error('zipcode')
          <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
          @enderror
        </div>
      </div>
      <div class="row mb-3">
        <label for="phone" class="col-lg-4 col-form-label text-lg-end">Telefon</label>

        <div class="col-lg-4">
          <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="phone">

          @error('phone')
          <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
          @enderror
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props:{
    old: {
      type: Array,
    },
    error: {
      type: Array,
    },
    addresses: {
      required: true,
      type: Array,
    }
  },
  data() {
    return {
      addressId: 0
    }
  },

}
</script>
