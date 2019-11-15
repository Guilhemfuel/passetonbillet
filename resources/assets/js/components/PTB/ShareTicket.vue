<template>
    <div v-if="(user != null && ticket.user && ticket.user.id == user.id)">
        <h5 class="mb-0">{{trans('tickets.component.share_modal.step_1')}}</h5>

        <div class="fb-share-btn">
            <div class="fb-share-button text-center"
                 :data-href="route('ticket.unique.page',[ticket.hashid])"
                 data-layout="button" data-size="large" data-mobile-iframe="true">
                <a target="_blank" :href="'https://www.facebook.com/sharer/sharer.php?u=' +
                        encodeURI(route('ticket.unique.page',[ticket.hashid]))
                        +'&amp;src=sdkpreparse'"
                   class="fb-xfbml-parse-ignore btn btn-facebook my-4">
                    <i class="fa fa-facebook-square" aria-hidden="true"></i>
                    {{trans('tickets.component.share_modal.share_on_fb')}}
                </a>
            </div>
        </div>

        <h5>{{trans('tickets.component.share_modal.step_2')}}</h5>

        <div class="container">
            <div class="row justify-content-center">


                <div class="col-12 col-sm-10 col-md-8">
                    <p class="text-center">{{trans('tickets.component.share_modal.text_link')}} :</p>

                    <input ref="sharelink" readonly type="text" class="form-control"
                           :value="route('ticket.unique.page',[ticket.hashid])"
                           aria-describedby="basic-addon2">
                    <el-popover
                            placement="bottom"
                            trigger="click"
                            :content="trans('tickets.component.copied')">
                        <div class="btn btn-block btn-ptb-blue mt-2" @click.prevent="share()" slot="reference">
                            <i class="fa fa-clipboard" aria-hidden="true"></i>
                            {{trans('tickets.component.share_modal.copy_link')}}
                        </div>
                    </el-popover>

                    <p class="text-center mt-4">{{trans('tickets.component.share_modal.our_fb_group')}}</p>

                    <div class="fb-group" data-href="https://www.facebook.com/groups/4856026601/"
                         data-width="300" data-show-social-context="true" data-show-metadata="false"
                         v-if="ticket.provider=='eurostar'"></div>

                    <div class="fb-group" data-href="https://www.facebook.com/groups/5042721942/"
                         data-width="300" data-show-social-context="true" data-show-metadata="false"
                         v-else-if="ticket.provider=='thalys' || ticket.provider=='izy'"></div>

                    <div class="fb-group" data-href="https://www.facebook.com/groups/38391320652/"
                         data-width="300" data-show-social-context="true" data-show-metadata="false"
                         v-else></div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    props: {
      ticket: {required: true}
    },
    data() {
      return {
        user: this.$root.user,
      }
    },
  }
</script>