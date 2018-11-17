<?php
/**
 * Class AttackerFinder
 * 问题：分析nginx日志文件，提取每行的ip和时间，给出条件，比如5分钟内访问过100次的ip为异常ip，找出这些ip
 * 思路：使用队列的形式，每个ip分配100个元素的队列，每次入队，判断是否已满，满的时候，计算队首和队尾的时间差，
 * 如果时间差大于5分钟，则是异常ip，小于5分钟，出队元素
 */
class AttackerFinder
{
    protected $attacker = [];

    /**
     * @param int $duration 时间间隔分钟
     * @param int $count 间隔时间内访问次数
     * @return array
     */
    public function find(int $duration = 30, int $count = 100)
    {
        $duration = $duration * 60;
        $source = $this->buildData($count * 100);
        $temp = [];
        foreach ($source as $item) {
            list($ip, $time) = $item;
            if (isset($this->attacker[$ip])) {
                $temp[$ip][] = $time;
                continue;
            }

            $temp[$ip][] = $time;
            $n = count($temp[$ip]);
            if ($n > $count - 1) {
                $start = $temp[$ip][0];
                $end = $temp[$ip][$n - 1];
                if ($end - $start > $duration) {
                    $this->attacker[$ip] = true;
                } else {
                    array_shift($temp[$ip]);
                }
            }
        }
        // ksort($temp);
        // print_r($temp);
        return array_keys($this->attacker);
    }

    public function buildData(int $count)
    {
        $list = [];
        $time = time();
        $maxIpId = intdiv($count, 300);
        for ($i = 0; $i < $count; $i ++) {
            $ipId = mt_rand(0, $maxIpId);
            $time = mt_rand(0, 1) ? $time : $time + 1;
            $list[] = [$ipId, $time];
        }
        return $list;
    }
}

$finder = new AttackerFinder();
$result = $finder->find();
print_r($result);
