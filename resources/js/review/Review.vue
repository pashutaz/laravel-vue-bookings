<template>
  <div>
    Review page
    <div class="form-group">
        <label for="" class="text-muted">Select the star rating</label>
        <star-rating :rating="5" class="fa-3x"></star-rating>
    </div>
    <div class="form-group">
        <label for="content" class="text-muted">Describe your experience</label>
        <textarea name="content" id="" cols="30" rows="10" class="form-control"></textarea>
    </div>

    <button class="btn btn-lg btn-primary btn-block">Submit</button>
  </div>
</template>
