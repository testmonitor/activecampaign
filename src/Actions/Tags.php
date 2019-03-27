<?php

namespace ByTestGear\ActiveCampaign\Actions;

use ByTestGear\ActiveCampaign\Resources\Tag;

trait Tags
{
    /**
     * Get all tags.
     *
     * @return array
     */
    public function tags()
    {
        return $this->transformCollection(
            $this->get('tags'),
            Tag::class,
            'tags'
        );
    }

    /**
     * Find tag by name.
     *
     * @return array
     */
    public function findTag($query = null)
    {
        $tags = $this->transformCollection(
            $this->get('tags', ['query' => ['search' => $query]]),
            Tag::class,
            'tags'
        );

        return array_pop($tags);
    }

    /**
     * Create new tag.
     *
     * @return array
     */
    public function createTag(array $data = [])
    {
        return $this->post('tags', ['json' => ['tag' => $data]]);
    }

    /**
     * Find or create a tag.
     *
     * @param $name
     *
     * @return mixed
     */
    public function findOrCreateTag(array $data)
    {
        $tag = $this->findTag($data['name']);

        if (empty($tag)) {
            $this->createTag($data);

            return $this->findTag($data['name']);
        }

        return $tag;
    }
}
