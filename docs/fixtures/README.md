# Fixtures

We need content to test layouts and features right? Let's generate some
random data based on customised recipes.

These recipes can be created on a file named *fixtures.yml*.
An example of recipies is below.

## Generating data

To start loading your database fire up your terminal.

```
wp fixtures load
```

## Remove inserted data

When you are done and want to clean up your database just run:

```
wp fixtures delete
```

## Recipe example

Here is some content as example for *fixtures.yml*.

```yaml
# List of options for some acf custom fields
parameters:
  event_type:
    - concert
    - conference
    - workshops
  event_states:
    - New
    - Canceled
    - Postponed
  sites:
    - Main
    - Musica
    - Museu

Hellonico\Fixtures\Entity\Term:
  language_pt:
    name: 'Portuguese'
    slug: pt
    taxonomy: 'language'
  language_en:
    name: 'English'
    slug: en
    taxonomy: 'language'
  sponsor{1..10}:
    name (unique): 'Sponsor <words(2, true)>'
    description: '<sentence()>'
    taxonomy: 'sponsorship'
    meta:
      url: '<url()>'

# Lets get some kitties on this
Hellonico\Fixtures\Entity\Attachment:
  attachment{1..5}:
    post_title: '<sentence()>'
    post_date: '<dateTimeThisDecade()>'
    file: <image(<uploadDir()>, 600, 600, 'cats')> # '<uploadDir()>' is required

# We need some locations and events
Hellonico\Fixtures\Entity\Post:
  location{1..5}:
    post_type: 'location'
    post_title: 'Location <sentence()>'
    post_content: '<paragraphs(5, true)>'
    post_date: '<dateTimeThisDecade()>'
    meta:
        meeting_point: '<numberBetween(0, 1)>'
        url: '<url()>'
        address: '<address()>'
  event{1..10}:
    post_type: 'event'
    post_title: 'Event <sentence()>'
    post_content: '<paragraphs(5, true)>'
    post_excerpt: '<paragraphs(1, true)>'
    post_date: '<dateTimeThisDecade()>'
    meta:
        _thumbnail_id: '@attachment*->ID'
        location: '<postId(post_type=location)>'
        lead: '<sentence()>'
        event_state: '<randomElement($event_states)>'
        event_type: '<randomElement($event_type)>'
        sites: '<randomElement($sites)>'

```

The YAML file is very *readable* but more documentation can be found on the
repositories of the projects used for this.

* [wp-cli-fixtures](https://github.com/nlemoine/wp-cli-fixtures)
* [Alice](https://github.com/nelmio/alice)
* [Faker](https://github.com/fzaninotto/Faker)
