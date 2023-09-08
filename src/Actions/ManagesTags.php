<?php

namespace TestMonitor\ActiveCampaign\Actions;

use TestMonitor\ActiveCampaign\Resources\Tag;

trait ManagesTags
{
    use ImplementsActions;

    /**
     * Get all tags.
     *
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function tags(int $limit = 100, int $offset = 0)
    {
        return $this->transformCollection(
            $this->get('tags', ['query' => ['limit' => $limit, 'offset' => $offset]]),
            Tag::class,
            'tags'
        );
    }

    /**
     * Find tag by name.
     *
     * @param string $name
     * @param int $limit
     * @param int $offset
     *
     * @return array
     */
    public function findTag($name, int $limit = 100, int $offset = 0)
    {
        $tags = $this->transformCollection(
            $this->get('tags', ['query' => ['search' => $name, 'limit' => $limit, 'offset' => $offset]]),
            Tag::class,
            'tags'
        );

        return array_shift($tags);
    }

    /**
     * Create new tag.
     *
     * @param array $data
     *
     * @return Tag
     */
    public function createTag(array $data = [])
    {
        $tags = $this->transformCollection(
            $this->post('tags', ['json' => ['tag' => $data]]),
            Tag::class
        );

        return array_shift($tags);
    }

    /**
     * Find or create a tag.
     *
     * @param string $name
     *
     * @return Tag
     */
    public function findOrCreateTag($name)
    {
        $tag = $this->findTag($name);

        if ($tag instanceof Tag) {
            return $tag;
        }

        return $this->createTag(['tag' => $name]);
    }
}
